<?php
namespace App\Services;

use DOMDocument;
use DOMXPath;

class TravelContentParser
{
    public static function parse(string $html): array
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8">' . $html);
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);

        // 🔹 HEADER
        $headerImages = $xpath->query('//table[1]//img');
        $titleNode = $xpath->query('//table[1]//span')->item(0);
        $subtitleNode = $xpath->query('//table[1]//span')->item(1);

        $header = [
            'background' => self::extractBackground($xpath->query('//table[1]//td')->item(0)),
            'left_image' => $headerImages->item(0)?->getAttribute('src'),
            'right_image' => $headerImages->item(1)?->getAttribute('src'),
            'title' => trim($titleNode?->textContent ?? ''),
            'subtitle' => trim($subtitleNode?->textContent ?? ''),
        ];

        // 🔹 GALLERY
        $gallery = [];
        foreach ($xpath->query('//table[position()>1 and position()<4]//img') as $img) {
            if ($img instanceof \DOMElement) {
            $gallery[] = $img->getAttribute('src');
            }
        }

        // 🔹 ITEMS
     
       $items = [];

foreach ($xpath->query('//table[last()]//table//tr') as $tr) {
    if (!$tr instanceof \DOMElement) continue;

    $imgs = $tr->getElementsByTagName('img');
    if ($imgs->length < 2) continue;

    $link = $tr->getElementsByTagName('a')->item(0);

    $items[] = [
        'title' => trim($link?->textContent ?? $tr->textContent),
        'slug' => $link ? trim($link->getAttribute('href'), '/') : null,
        'left_image' => $imgs->item(0)->getAttribute('src'),
        'right_image' => $imgs->item(1)->getAttribute('src'),
    ];
}

        return [
            'type' => 'travel-table-post',
            'header' => $header,
            'gallery' => $gallery,
            'items' => $items,
        ];
    }

    private static function extractBackground($td): ?string
    {
        if (!$td) return null;

        preg_match('/url\([\'"]?(.*?)[\'"]?\)/', $td->getAttribute('style'), $m);
        return $m[1] ?? null;
    }
}