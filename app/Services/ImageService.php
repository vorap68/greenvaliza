<?php
namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Drivers\Imagick\Encoders\JpegEncoder;
use Intervention\Image\Drivers\Imagick\Encoders\PngEncoder;
use Intervention\Image\ImageManager;

class ImageService
{
    protected ImageManager $manager;
    protected string $disk = 'public';
    public $path;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());

    }

    public function dirToName(string $folder1, string $folder2 ): void
    {
        $dir = Storage::disk('public')->path('/images/' . $folder1.$folder2);
        dump("folder1: ".$folder1);
        dump("folder2: ".$folder2);
       // dd($dir);

        $rii = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS)
        );
        $fileName = [];
        foreach ($rii as $file) {
            /** @var \SplFileInfo $file */
            if ($file->isDir()) {
                continue;
            }
            $fileName[] = $file->getPathname();
        }
       
        // dump(basename($fileName[0]));
        foreach ($fileName as $file) {
             $lastdir = basename(dirname($file));
            $this->saveResizedImages($file, $lastdir, $folder1,$folder2 );
        }

    }

    public function saveResizedImages($source, $lastdir,$folder1,$folder2 ): array
    {
        // Размеры: ключ => [width, height, use_as_width_for_srcset]
        $sizes = [
            'thumb'  => [150, 150],
            'onesmall'  => [200, 200],
            'small'  => [400, 400],
            'medium' => [600, 400],
            '768x768' => [768, 768],
            'large'  => [1200, 800],
            'og'     => [1200, 630],
        ];

        // Получаем контент изображения / путь
        $imageData = $this->loadImageData($source);
        // Сделаем базовое имя
        $basename   = pathinfo($imageData['filename'], PATHINFO_FILENAME);
        $imageExten = pathinfo($imageData['filename'], PATHINFO_EXTENSION);
        //$basename = Str::slug($basename);
        dump($lastdir, $basename, $imageExten);

        $results = [];

        // Кодируем исход в строку, чтобы многократно делать make() без побочек
        $originalBlob = $imageData['contents'];

        foreach ($sizes as $key => [$w, $h]) {
            $filename = "{$basename}_{$key}";
            // $ext    = $format === 'png' ? 'png' : 'jpg';

            //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
           // $path = "images/categoryMenu/nashi-puteshestviya/$lastdir/{$filename}.{$imageExten}";
            $path = "images/{$folder1}/{$folder2}/$lastdir/{$filename}.{$imageExten}";
           // $path = "images/categories/$lastdir/{$filename}.{$imageExten}";

            //dd($path);

            try {
                // каждый раз делаем новый объект из исходных байтов
                $img = $this->manager->read($originalBlob);

                // учитывать ориентацию EXIF (если есть)
                if (method_exists($img, 'orientate')) {
                    @$img->orientate();
                }

                // ресайз — сохраняем пропорции, без увеличения
                $img->resize($w, $h, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                switch ($imageExten) {
                    case 'jpg':
                    case 'jpeg':
                        $encoded = $img->encode(new JpegEncoder(quality: 90));
                        break;
                    case 'png':
                        $encoded = $img->encode(new PngEncoder());
                        break;
                    default:
                        $encoded = $img->encode(new JpegEncoder(quality: 90));
                }

                //
                //dd(Storage::disk('public')->url($path));
                Storage::disk('public')->put($path, $encoded);
                $results[$key] = Storage::url($path);

            } catch (Exception $e) {
                // логируем или пробрасываем — зависит от политики вашего приложения
                throw new Exception("Ошибка при обработке размера {$key}: " . $e->getMessage());
            }
        }

        // Соберём srcset (widths для каждого размера)
        $srcsetParts = [];
        foreach ($sizes as $key => [$w, $h]) {
            if (isset($results[$key])) {
                $srcsetParts[] = $results[$key] . ' ' . $w . 'w';
            }
        }
        dump($srcsetParts);
        $results['srcset'] = implode(', ', $srcsetParts);

        print_r($results);
        // die();
        return $results;
    }

    protected function loadImageData($source): array
    {
        $contents = null;

        // Загружаем из локального файла
        $contents = file_get_contents($source);
        $filename = basename($source);

        return [
            'contents' => $contents,
            'filename' => $filename,
        ];
    }

}
