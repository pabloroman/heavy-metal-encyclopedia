<?php

namespace App\Helpers;

class Album
{
    public static function bandLinks($album)
    {
        $links = [];
        foreach ($album->bandDetails as $band) {
            $links[] = "<a href=".$band['permalink'].">".$band['name']."</a>";
        }

        return implode(' / ', $links);
    }
}
