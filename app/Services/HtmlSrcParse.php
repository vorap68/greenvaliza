<?php

namespace App\Services;

use Illuminate\Support\Str;

/**
 * Сервис для парсинга HTML-контента для получения путей катринок в тестах постов
 */
class HtmlSrcParse
{
    /**
     * Основной метод для парсинга HTML-контента и извлечения данных для header, gallery и items
     * @param string $html  HTML-контент из поля content тревел таблицы
     * @return array  Массив с данными для header, gallery и items
     */
    public static function extractSrcPath( array|string $content): array
    {
        $sources = [];
        if (isset($content['data']['content']) &&  is_string($content['data']['content'])) {
            $html = $content['data']['content'];
            // dump($html);
            $dom = new \DOMDocument();
            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

            $xpath = new \DOMXPath($dom);
            $elements = $xpath->query('//*[@src]');
            foreach ($elements as $element) {
                $sources[] = $element->getAttribute('src');
            }
        } else {
            array_walk_recursive($content, function ($value) use (&$sources) {
                if (is_string($value) && Str::startsWith($value, '/storage/')) {
                    $sources[] = $value;
                }
            });
        };
        return $sources;
    }
}
