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

    public function saveResizedImages(array $filePathArray) 
    {
        // пример элемента массива fileNameArray
        // /var/www/storage/app/public/images/mybook/2/original/my.jpg
        foreach ($filePathArray as $key => $source) {
            // return response()->json(['key'=>$key,'source' => $source]);
            // Размеры: ключ => [width, height, use_as_width_for_srcset]
            $sizes = [
                '150'  => [150, 150, 'cover'],
                '400'  => [400, null, 'scaleDown'],
                '600'  => [600, null, 'scaleDown'],
                '768'  => [768, null, 'scaleDown'],
                '1200' => [1200, null, 'scaleDown'],
            ];

            // Получаем контент изображения / путь
            $imageData = $this->loadImageData($source);
            // Сделаем базовое имя и расширение
            $basename   = pathinfo($imageData['filename'], PATHINFO_FILENAME);
            $imageExten = pathinfo($imageData['filename'], PATHINFO_EXTENSION);
            //  return response()->json(['source' => $source, 'basename' => $basename,'imageExten'=>$imageExten]);
            $results = [];
            // Кодируем исход в строку, чтобы многократно делать make() без побочек
            $originalBlob = $imageData['contents'];
            $absoluteDir  = dirname($source);

            // убираем /original
            $absoluteDir = str_replace(
                DIRECTORY_SEPARATOR . 'original',
                '',
                $absoluteDir
            );
            // dump('Абсолютный путь к директории_новый', $absoluteDir);
            $relativeDir = str_replace(
                storage_path('app/public') . '/',
                '', $absoluteDir);
            //  dump('Относительный путь к директории для сохранения', $relativeDir);

        //    // Добавл права на папку resize
        //    $resizeDir = Storage::disk('public')->path( "{$relativeDir}/resize");
        //    if(is_dir($resizeDir)){
        //    //return response()->json(['path', $resizeDir]);
        //     chmod($resizeDir, 0777);
        //    }

            foreach ($sizes as $key => [$w, $h, $mode]) {
                $filename = "{$basename}_{$key}";
                $path     = "{$relativeDir}/resize/{$filename}.{$imageExten}";
                //return response()->json(['path', $path]);

                try {
                    // каждый раз делаем новый объект из исходных байтов
                    $img = $this->manager->read($originalBlob);

                    // учитывать ориентацию EXIF (если есть)
                    if (method_exists($img, 'orient')) {
                        $img->orient();
                    }
                    if ($mode === 'cover') {
                        $img->cover($w, $h);

                    } elseif ($mode === 'scaleDown') {
                        if ($w && ! $h) {
                            $img->scaleDown(width: $w);
                        } elseif (! $w && $h) {
                            $img->scaleDown(height: $h);
                        } else {
                            $img->scaleDown(width: $w, height: $h);
                        }

                    } elseif ($mode === 'scale') {
                        if ($w && ! $h) {
                            $img->scale(width: $w);
                        } elseif (! $w && $h) {
                            $img->scale(height: $h);
                        } else {
                            $img->scale(width: $w, height: $h);
                        }
                    }

                    // Кодируем в нужный формат
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
                    //  dd($encoded);

                   $success = Storage::disk('public')->put($path, (string) $encoded);
                  
                  // return response()->json(['save result', $success, $path]);

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
          
        }
             return $success;
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
