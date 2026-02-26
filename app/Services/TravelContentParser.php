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
        $titleNode    = $xpath->query('//table[1]//span')->item(0);
        $subtitleNode = $xpath->query('//table[1]//span')->item(1);

        $header = [
            'background'  => self::extractBackground($xpath->query('//table[1]//td')->item(0)),
            'left_image'  => self::withSize(
                $headerImages->item(0)?->getAttribute('src'),
                150
            ),
            'right_image' => self::withSize(
                $headerImages->item(1)?->getAttribute('src'),
                150
            ),
         
            'title'       => trim($titleNode?->textContent ?? ''),
            'subtitle'    => trim($subtitleNode?->textContent ?? ''),

               'title_color'    => self::extractColor($titleNode),
           'subtitle_color' => self::extractColor($subtitleNode),
        ];

        // 🔹 GALLERY
        $gallery = [];
        foreach ($xpath->query('//table[position()>1 and position()<4]//img') as $img) {
            if ($img instanceof \DOMElement) {
                $gallery[] = self::withSize(
                    $img->getAttribute('src'),
                    1200
                );
            }
        }

        // 🔹 ITEMS

        $items = [];

        foreach ($xpath->query('//table[last()]//table//tr') as $tr) {
            if (! $tr instanceof \DOMElement) {
                continue;
            }

            $imgs = $tr->getElementsByTagName('img');
            if ($imgs->length < 2) {
                continue;
            }

               $tds = $tr->getElementsByTagName('td');
            $link = $tr->getElementsByTagName('a')->item(0);

              $bgColor = null;
    if ($tds->length >= 2) {
        $bgColor = $tds->item(1)->getAttribute('bgcolor');
    }

            $items[] = [
                'title'       => trim($link?->textContent ?? $tr->textContent),
                'slug'        => $link ? trim($link->getAttribute('href'), '/') : null,
                'left_image'  => self::withSize(
                    $imgs->item(0)->getAttribute('src'),
                    400
                ),
                'right_image' => self::withSize(
                    $imgs->item(1)->getAttribute('src'),
                    400
                ),
                 'bgcolor'  => $bgColor,
            ];
        }

        return [
            'type'    => 'travel-table-post',
            'header'  => $header,
            'gallery' => $gallery,
            'items'   => $items,
        ];
    }

    private static function extractBackground($td): ?string
    {
        if (! $td) {
            return null;
        }
        preg_match('/url\([\'"]?(.*?)[\'"]?\)/', $td->getAttribute('style'), $m);
        if (! isset($m[1])) {
            return null;
        }
        // Убираем /resize из пути
        return str_replace('/resize', '', $m[1]);
    }

    //метод для выбора файлов фото разных размеров для gallery,item,header
    private static function withSize($path, int $size): string
    {
        $info = pathinfo($path);

        return $info['dirname'] . '/' .
            $info['filename'] . '_' . $size . '.' .
            $info['extension'];
    }

    //метод для извлечения цвета текста из стиля
    private static function extractColor( ? \DOMElement $node): ?string
    {
        if (! $node) {
            return null;
        }
        $style = $node->getAttribute('style');
        if (! $style) {
            return null;
        }
        preg_match('/color\s*:\s*([^;]+)/i', $style, $m);
        return $m[1] ?? null;
    }
}
