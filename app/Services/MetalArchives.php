<?php

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client as GuzzleClient;
use Symfony\Component\DomCrawler\Crawler;

class MetalArchives
{
    public static $base_url = 'https://www.metal-archives.com';
    public static $band_discography_url = '/band/discography/id/%s/tab/all';

    public function getBandDiscography($band_id)
    {
        $url = sprintf(self::$band_discography_url, $band_id);

        $client = new GuzzleClient(['base_uri' => self::$base_url]);

        $response = $client->get($url);

        if (200 === $response->getStatusCode()) {
            return $this->parseBandDiscography((string) $response->getBody());
        } else {
            throw new Exception('Response: HTTP status ' . $response->getStatusCode() . '. Aborting');
        }
    }

    public function getReview($url)
    {
        $client = new GuzzleClient(['base_uri' => self::$base_url]);

        $response = $client->get($url);

        if (200 === $response->getStatusCode()) {
            return $this->parseReview((string) $response->getBody());
        } else {
            throw new Exception('Response: HTTP status ' . $response->getStatusCode() . '. Aborting');
        }
    }

    private function parseBandDiscography($html)
    {
        $crawler = new Crawler($html);

        return $crawler->filter('tbody')->children('tr')->each(function ($item) {
            $album_properties = $item->children('td');

            $permalink = $album_properties->eq(0)->children('a')->eq(0)->attr('href');
            $title = trim($album_properties->eq(0)->children('a')->eq(0)->text());
            $type = trim($album_properties->eq(1)->text());
            $year = trim($album_properties->eq(2)->text());
            $id = $this->getAlbumId($permalink);
            $image_url = $this->getAlbumImageUrl($id);

            return compact('id', 'permalink', 'title', 'type', 'year', 'image_url');
        });
    }

    private function parseReview($html)
    {
        $crawler = new Crawler($html);

        $title = trim($crawler->filter('.reviewTitle')->text());
        $content = trim($crawler->filter('.reviewContent')->text());

        return compact('title', 'content');
    }

    private function getAlbumId($permalink)
    {
        $segments = explode('/', $permalink);

        return $segments[sizeof($segments)-1];
    }

    private function getAlbumImageUrl($id)
    {
        return 'https://www.metal-archives.com/images/'.implode('/', str_split(substr($id, 0, 4)))."/".$id.".jpg";
    }

    private function getBandId($permalink)
    {
        $segments = explode('/', $permalink);

        return $segments[sizeof($segments)-1];
    }
}
