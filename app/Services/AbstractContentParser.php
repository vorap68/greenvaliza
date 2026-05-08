<?php
namespace App\Services;

use DOMDocument;
use DOMXPath;

abstract class AbstractContentParser
{
    protected DOMDocument $dom;
    protected DOMXPath $xpath;

    public function __construct(string $html)
    {
        $this->load_htmi($html);
    }

    protected function load_htmi(string $html): void
    {
        $this->dom = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $this->dom->loadHTML('<?xml encoding="UTF-8">' . $html);
        libxml_clear_errors();
        $this->xpath = new DOMXPath($this->dom);
    }

    abstract public function parse(): array;

    protected function extractBackground($td): ?string
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
    protected function withSize($path, int $size): string
    {
        $info = pathinfo($path);

        return $info['dirname'] . '/' .
            $info['filename'] . '_' . $size . '.' .
            $info['extension'];
    }

    //метод для извлечения цвета текста из стиля
    protected function extractColor( ? \DOMElement $node): ?string
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
