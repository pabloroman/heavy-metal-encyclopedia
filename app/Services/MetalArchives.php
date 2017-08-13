<?php

namespace App\Services;

use Storage;
use Carbon\Carbon;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException as GuzzleException;
use Symfony\Component\DomCrawler\Crawler;

class MetalArchives
{
    public static $base_url = 'https://www.metal-archives.com';
    public static $band_discography_url = '/band/discography/id/%s/tab/all';
    public static $album_url = '/albums/_/_/%s';
    public static $review_url = '/reviews/_/_/%s/_/%s';

    private function getUrl($url, $type)
    {
        if (Storage::exists($type . '/' . urlencode($url))) {
            $page = Storage::get($type . '/' . urlencode($url));
        } else {
            $client = new GuzzleClient(['base_uri' => self::$base_url]);
            try {
                $response = $client->get($url);
            } catch (GuzzleException $e) {
                return ['error' => $e->getResponse()->getStatusCode()];
            }
            $page = (string) $response->getBody();
            Storage::put($type . '/' . urlencode($url), $page);
        }

        return $page;
    }

    public function getBandDiscography($band_id)
    {
        $url = sprintf(self::$band_discography_url, $band_id);
        $page = $this->getUrl($url, 'band_discography');

        if (is_array($page) && isset($page['error'])) {
            return $page['error'];
        }

        return $this->parseBandDiscography($page);
    }

    public function getReview($album_id, $review_id)
    {
        $url = sprintf(self::$review_url, $album_id, $review_id);
        $page = $this->getUrl($url, 'reviews');

        if (is_array($page) && isset($page['error'])) {
            return $page['error'];
        }

        return $this->parseReview($page);
    }

    public function getAlbum($url_or_id)
    {
        if (is_numeric($url_or_id)) {
            $url = sprintf(self::$album_url, $url_or_id);
        } else {
            $url = $url_or_id;
        }
        $page = $this->getUrl($url, 'albums');

        if (is_array($page) && isset($page['error'])) {
            return $page['error'];
        }

        return $this->parseAlbum($page);
    }

    public function getBand($url)
    {
        $page = $this->getUrl($url, 'bands');

        if (is_array($page) && isset($page['error'])) {
            return $page['error'];
        }

        return $this->parseBand($page);
    }

    private function parseBandDiscography($html)
    {
        $crawler = new Crawler($html);

        return $crawler->filter('tbody')->children('tr')->each(function ($item) {
            $album_properties = $item->children('td');

            $permalink = $album_properties->eq(0)->children('a')->eq(0)->attr('href');
            $id = $this->getAlbumId($permalink);

            return compact('id', 'permalink');
        });
    }

    private function parseReview($html)
    {
        $crawler = new Crawler($html);

        $title = preg_replace('/ \- (\d+)\%$/', '${2}', trim($crawler->filter('.reviewTitle')->text()));
        $body = trim($crawler->filter('.reviewContent')->text());

        return compact('title', 'body');
    }

    private function parseAlbum($html)
    {
        $crawler = new Crawler($html);

        $title = $crawler->filter('.album_name')->text();
        try {
            $image_url_original = $crawler->filter('#cover')->children('img')->attr('src');
        } catch (\Exception $e) {
            $image_url_original = null;
        }
        $type = $crawler->filter('dl.float_left')->children('dd')->eq(1)->text();
        $label = $crawler->filter('dl.float_right')->children('dd')->eq(1)->text();
        $date = $crawler->filter('dl.float_left')->children('dd')->eq(3)->text();
        $published_at = (strlen($date) == 4) ? Carbon::parse($date . '-01-01') : Carbon::parse($date);

        return compact('title', 'image_url_original', 'type', 'published_at', 'label');
    }

    private function parseBand($html)
    {
        $crawler = new Crawler($html);

        $name = $crawler->filter('.band_name')->text();
        try {
            $logo = $crawler->filter('#logo')->children('img')->attr('src');
        } catch (\Exception $e) {
            $logo = null;
        }
        try {
            $image_url_original = $crawler->filter('#photo')->children('img')->attr('src');
        } catch (\Exception $e) {
            $image_url_original = null;
        }
        $country = $crawler->filter('dl.float_left')->children('dd')->eq(1)->text();
        $status = $crawler->filter('dl.float_left')->children('dd')->eq(5)->text();
        $founded_at = $crawler->filter('dl.float_left')->children('dd')->eq(7)->text();
        $genre = $crawler->filter('dl.float_right')->children('dd')->eq(1)->text();
        $lyrical_themes = $crawler->filter('dl.float_right')->children('dd')->eq(3)->text();

        return compact('name', 'logo', 'image_url_original', 'country', 'status', 'founded_at', 'genre', 'lyrical_themes');
    }

    private function getAlbumId($permalink)
    {
        $segments = explode('/', $permalink);

        return $segments[sizeof($segments)-1];
    }

    private function getBandId($permalink)
    {
        $segments = explode('/', $permalink);

        return $segments[sizeof($segments)-1];
    }
}
