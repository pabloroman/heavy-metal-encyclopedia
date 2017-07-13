<?php

namespace App\Helpers;

use DOMDocument;
use Symfony\Component\DomCrawler\Crawler;

class Parser
{
    public static function parseLink($link)
    {
        $crawler = new Crawler($link);
        $permalink = $crawler->filter('a')->attr('href');
        $tokens = explode('/', $permalink);

        return [
            'permalink' => urldecode($permalink),
            'id' => $tokens[sizeof($tokens)-1],
        ];
    }

    public static function parseScore($score)
    {
        return str_replace('%', '', $score);
    }
}
