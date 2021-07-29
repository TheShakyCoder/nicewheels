<?php

namespace App\Services;

class NewsService
{
    public function feed($quantity)
    {
        $autoExpressFeed = file_get_contents('https://www.autoexpress.co.uk/car-news/feed');
        $xml = simplexml_load_string($autoExpressFeed, null,LIBXML_NOCDATA);
        $json = json_encode($xml);
        $data = json_decode($json,TRUE);

        return array_splice($data['channel']['item'], 0, $quantity);
    }
}
