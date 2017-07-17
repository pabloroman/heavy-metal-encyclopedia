<?php

namespace App\Services;

use Storage;
use Carbon\Carbon;
use GuzzleHttp\Client as GuzzleClient;
use Symfony\Component\DomCrawler\Crawler;

class MetalArchives
{
    public static $base_url = 'https://www.metal-archives.com';
    public static $band_discography_url = '/band/discography/id/%s/tab/all';

    private function getUrl($url, $type)
    {
        if (Storage::exists($type . '/' . urlencode($url))) {
            $page = Storage::get($type . '/' . urlencode($url));
        } else {
            $client = new GuzzleClient(['base_uri' => self::$base_url]);
            $response = $client->get($url);
            if (200 === $response->getStatusCode()) {
                $page = (string) $response->getBody();
                Storage::put($type . '/' . urlencode($url), $page);
            } else {
                throw new Exception('Response: HTTP status ' . $response->getStatusCode() . '. Aborting');
            }
        }

        return $page;
    }

    public function getBandDiscography($band_id)
    {
        $url = sprintf(self::$band_discography_url, $band_id);
        $page = $this->getUrl($url, 'band_discography');

        return $this->parseBandDiscography($page);
    }

    public function getReview($url)
    {
        $page = $this->getUrl($url, 'reviews');

        return $this->parseReview($page);
    }

    public function getAlbum($url)
    {
        $page = $this->getUrl($url, 'albums');

        return $this->parseAlbum($page);
    }

    public function getBand($url)
    {
        $page = $this->getUrl($url, 'bands');

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
            $image = $crawler->filter('#cover')->children('img')->attr('src');
        } catch (\Exception $e) {
            $image = null;
        }
        $type = $crawler->filter('dl.float_left')->children('dd')->eq(1)->text();
        $label = $crawler->filter('dl.float_right')->children('dd')->eq(1)->text();
        $date = $crawler->filter('dl.float_left')->children('dd')->eq(3)->text();
        $published_at = (strlen($date) == 4) ? Carbon::parse($date . '-01-01') : Carbon::parse($date);
    
        return compact('title', 'image', 'type', 'published_at', 'label');
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
            $image = $crawler->filter('#photo')->children('img')->attr('src');
        } catch (\Exception $e) {
            $image = null;
        }
        $country = $crawler->filter('dl.float_left')->children('dd')->eq(1)->text();
        $status = $crawler->filter('dl.float_left')->children('dd')->eq(5)->text();
        $founded_at = $crawler->filter('dl.float_left')->children('dd')->eq(7)->text();
        $genre = $crawler->filter('dl.float_right')->children('dd')->eq(1)->text();
        $lyrical_themes = $crawler->filter('dl.float_right')->children('dd')->eq(3)->text();

        return compact('name', 'logo', 'image', 'country', 'status', 'founded_at', 'genre', 'lyrical_themes');
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
