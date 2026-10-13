<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\HtmlSrcParse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Trait\HelperRandom;

/**
 * Метод выбирает случ категорию  $cat , и в этой категории 
 * и в этой категории выбирает случ пост $post_slug
 * Далее в зависимости от от названия категории (travel или нет) идет запрос на разные адреса
 * для получения контента выбраного поста.
 * Метод HtmlSrcParse::extractSrcPath($content) возвращает массив располежения всех фото в проекте
 * Метод imagesControl проверяет фактическое наличие фото в указанных папках
  */
class PostsGetTest extends TestCase
{
    use HelperRandom;
    /**
     * A basic feature test example.
     */
    public function test_get_random_post(): void
    {
        $cat_name = $this->randomCategory();

        dump('Выбрана категория получения поста', $cat_name);
        echo "Нажмите Enter...";
        fgets(STDIN);
        $all_posts = $this->get("/api/$cat_name")->json('data');
        $post_rand = array_rand($all_posts);
        $post_type = $all_posts[$post_rand]['type'];
        $post_type = $post_type  == 'tble' ? 'table' :  $post_type;
          dump('Выбрана тип', $post_type);
        $post_slug = $all_posts[$post_rand]['slug'];
        $post_title = $all_posts[$post_rand]['title'];
        dump('Выбран пост', $post_title);
        echo "Нажмите Enter...";
        fgets(STDIN);
        if ($cat_name === 'travel' && $post_type != null) {
            $single_post = $this->get("/api/$cat_name/$post_type/$post_slug");
        } else {
            $single_post = $this->get("/api/$cat_name/$post_slug");
        };
           $content = $single_post->json();
           dump('content:',$content);
           if($post_type === 'table'){
             $slug = $content['slug'];
                $this->assertDatabaseHas($cat_name . '_table', [
                    'slug' => $slug,
                ]);
                dump("✔ PASS — БД: пост '{$slug}' найден в {$cat_name}_posts");
           }else{
             $slug = $content['data']['slug'];
                $this->assertDatabaseHas($cat_name.'_posts', [
                    'slug' => $slug,
                ]);
                dump("✔ PASS — БД: пост '{$slug}' найден в {$cat_name}_posts");
           }
      
                $html = $single_post->json('data.content');
        if(empty($html)) dd($slug);
        $sources = HtmlSrcParse::extractSrcPath($content);
        $this->imagesControl($sources);
        $all_cat_name =  [];
       
    }

    private function imagesControl(array $sources): void
    {
        foreach ($sources as $picture_path) {
            $result = Str::remove('/storage', $picture_path);
            $exists = Storage::disk('public')->exists($result);
            dump(($exists ? '✔ pass' : '✘ fail') . " {$picture_path}");
            $this->assertTrue(
                $exists,
                "Файл {$picture_path} не найден."
            );
        }
    }
}
