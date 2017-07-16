<?php

namespace App\Helpers;

use DOMDocument;
use Symfony\Component\DomCrawler\Crawler;

class Parser
{
    public static function parseReviewLink($html)
    {
        return self::parseSingleLink($html);
    }

    public static function parseAlbumLink($html)
    {
        return self::parseSingleLink($html);
    }

    public static function parseBandsLink($html)
    {
        return self::parseMultipleLinks($html);
    }

    public static function parseAuthorLink($html)
    {
        return self::parseSingleLink($html);
    }

    public static function parseScore($score)
    {
        return str_replace('%', '', $score);
    }

    private static function parseSingleLink($html)
    {
        $crawler = new Crawler($html);
        $permalink = $crawler->filter('a')->attr('href');
        $tokens = explode('/', $permalink);

        return [
            'permalink' => urldecode($permalink),
            'id' => $tokens[sizeof($tokens)-1],
        ];
    }

    private static function parseMultipleLinks($html)
    {
        $crawler = new Crawler($html);
        return $crawler->filter('a')->each(function ($item) {
            $permalink = $item->attr('href');
            $tokens = explode('/', $permalink);

            return [
                'permalink' => urldecode($permalink),
                'id' => $tokens[sizeof($tokens)-1],
            ];
        });
    }
}
