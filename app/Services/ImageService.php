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

    public function dirToName(string $folder1,  $folder2 = null ): void
    {
        $dir = Storage::disk('public')->path('/images/' . $folder1.$folder2);
      
        // Рекурсивный итератор для обхода всех файлов в директории и поддиректориях
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
       
        // Перебираем все файлы и создаём нужные размеры
        foreach ($fileName as $file) {
             $lastdir = basename(dirname($file));
            $this->saveResizedImages($file, $lastdir, $folder1,$folder2 );
        }

    }

    public function saveResizedImages($source, $lastdir,$folder1,$folder2 ): array
    {
        // Размеры: ключ => [width, height, use_as_width_for_srcset]
      $sizes = [
            'thumb'     => [150, 150, 'cover'],   // квадрат, как fit
            'onesmall'  => [200, 200, 'cover'],
            'small'     => [400, 400, 'resize'],
            'medium'    => [600, 400, 'resize'],
            '768x768'   => [768, 768, 'cover'],   // квадрат с кропом
            'large'     => [1200, 800, 'resize'],
            'og'        => [1200, 630, 'resize'],
        ];


        // Получаем контент изображения / путь
        $imageData = $this->loadImageData($source);
        // Сделаем базовое имя и расширение
        $basename   = pathinfo($imageData['filename'], PATHINFO_FILENAME);
        $imageExten = pathinfo($imageData['filename'], PATHINFO_EXTENSION);
        dump($lastdir, $basename, $imageExten);

        $results = [];

        // Кодируем исход в строку, чтобы многократно делать make() без побочек
        $originalBlob = $imageData['contents'];

        foreach ($sizes as $key =>[$w, $h, $mode]) {
            $filename = "{$basename}_{$key}";
           $path = "images/{$folder1}/{$folder2}/$lastdir/{$filename}.{$imageExten}";
          
    try {
                // каждый раз делаем новый объект из исходных байтов
                $img = $this->manager->read($originalBlob);

                // учитывать ориентацию EXIF (если есть)
                if (method_exists($img, 'orientate')) {
                      $img->orient();
                }
                if ($mode === 'cover') {
                    // аналог fit()
                    $img->cover($w, $h);
                } elseif ($mode === 'resize') {
                    $img->resize($w, $h, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }


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
