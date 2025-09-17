<?php

namespace App\Services;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class ScraperService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout'  => 60.0,
        ]);
    }

    public function scrape(string $url): array
    {
        $response = $this->client->request('GET', $url);
        $html = (string) $response->getBody();
        $crawler = new Crawler($html);

        $title = $crawler->filter('h1')->text();
        $price = $crawler->filter('._30jeq3._16Jk6d')->text();
        $image = $crawler->filter('._396cs4._2amPTt._3qGmMb')->attr('src');

        return [
            'title' => $title,
            'price' => $this->formatPrice($price),
            'image' => $image,
        ];
    }

    private function formatPrice(string $price): float
    {
        return (float) str_replace(['₹', ','], '', $price);
    }
}

