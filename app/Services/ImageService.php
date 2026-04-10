<?php
namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Drivers\Imagick\Encoders\JpegEncoder;
use Intervention\Image\Drivers\Imagick\Encoders\PngEncoder;
use Intervention\Image\ImageManager;


/**
 * 
 */
class ImageService
{
    protected ImageManager $manager;
    protected string $disk = 'public';
    public $path;

    /**
     * Конструктор для инициализации менеджера изображений с драйвером Imagick
     
     */
    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Метод для создания ресайзов изображения и сохранения их на диске
     * @param array $filePathArray Массив путей к исходным изображениям для обработки
     * @return bool Результат успешности сохранения изображений
     */
    public function saveResizedImages($filePathArray) 
    {
        if (!is_array($filePathArray) ) {
            $filePathArray = [$filePathArray];
        }
        //return response()->json(['filePathArray' => $filePathArray]);
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
                $success = Storage::disk('public')->put($path, (string) $encoded);
                  
                  // return response()->json(['save result', $success, $path]);

                } catch (Exception $e) {
                    // логируем или пробрасываем — зависит от политики вашего приложения
                    throw new Exception("Ошибка при обработке размера {$key}: " . $e->getMessage());
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
