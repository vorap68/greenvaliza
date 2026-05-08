<?php
namespace App\Services;

/**
 * Сервис для парсинга HTML-контента из travel-table-post и извлечения данных для header, gallery и items
 * Используется для обработки контента при извлечении постов в категорию travel-final на фронте
 * Позволяет извлекать изображения, заголовки, подзаголовки, цвета текста и другие данные из HTML-структуры поста
 * Те DomDocument и DOMXPath для парсинга HTML и извлечения нужных данных
 * для удобной работы с компонентом на фронте
 * и формировать массив данных для сохранения в базе данных и отображения на сайте
 */
class TravelContentParser extends AbstractContentParser
{
    /**
     * Основной метод для парсинга HTML-контента и извлечения данных для header, gallery и items
     * @param string $html  HTML-контент из поля content тревел таблицы
     * @return array  Массив с данными для header, gallery и items
     */
    public function parse(): array
    {

      // 🔹 GALLERY
       

        // 🔹 ITEMS

      

        return [
            'type'    => 'travel-table-post',
            'header'  => $this->parseHeader(),
            'gallery' => $this->parseGallery(),
            'items'   => $this->parseItems(),
        ];
    }
    private function parseHeader(): array
    {
        $headerImages = $this->xpath->query('//table[1]//img');
        $titleNode    = $this->xpath->query('//table[1]//span')->item(0);
        $subtitleNode = $this->xpath->query('//table[1]//span')->item(1);

        $header = [
            'background'     => $this->extractBackground($this->xpath->query('//table[1]//td')->item(0)),
            'left_image'     => $this->withSize(
                $headerImages->item(0)?->getAttribute('src'),
                150
            ),
            'right_image'    => $this->withSize(
                $headerImages->item(1)?->getAttribute('src'),
                150
            ),

            'title'          => trim($titleNode?->textContent ?? ''),
            'subtitle'       => trim($subtitleNode?->textContent ?? ''),

            'title_color'    => $this->extractColor($titleNode),
            'subtitle_color' => $this->extractColor($subtitleNode),
        ];
        return $header;
    }

    private function parseGallery(): array
    {
     $gallery = [];
        foreach ($this->xpath->query('//table[position()>1 and position()<4]//img') as $img) {
            if ($img instanceof \DOMElement) {
                $gallery[] = $this->withSize(
                    $img->getAttribute('src'),
                    1200
                );
            }
        }
        return $gallery;
    }

    private function parseItems(): array
    {
        $items = [];
        foreach ($this->xpath->query('//table[position()>3]') as $table) {
            if ($table instanceof \DOMElement) {
                $imgNode      = $this->xpath->query('.//img', $table)->item(0);
                $titleNode    = $this->xpath->query('.//span[1]', $table)->item(0);
                $subtitleNode = $this->xpath->query('.//span[2]', $table)->item(0);

                $items[] = [
                    'image'         => $this->withSize(
                        $imgNode?->getAttribute('src'),
                        600
                    ),
                    'title'         => trim($titleNode?->textContent ?? ''),
                    'subtitle'      => trim($subtitleNode?->textContent ?? ''),
                    'title_color'   => $this->extractColor($titleNode),
                    'subtitle_color'=> $this->extractColor($subtitleNode),
                ];
            }
        }
        return $items;
    }
}
