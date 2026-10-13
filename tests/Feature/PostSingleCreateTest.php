<?php

namespace Tests\Feature;

use App\Models\Posts\TravelTable;
use App\Trait\HelperRandom;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\FakePostData;


class PostSingleCreateTest extends TestCase
{
    use HelperRandom;
    /**
     * Здесь создаем посты-карточки для гл меню
     * затем к этим карточкам создаем конечные посты для всех категорий
     * ОТЛИЧИЕ для конечных постов в таблице (travel) , здесь мы карточки НЕ создаем .
     * И проверяем наличие в БД новых постов  
     */
    public function test_greate_single_post(): void
    {
        $cat_name = $this->randomCategory();
        dump('Выбрана категория создания поста', $cat_name);
        echo "Нажмите Enter...";
        fgets(STDIN);
        if ($cat_name === 'travel') {
            $travel_item = $this->randomTravelItem();
            if ($travel_item->type === 'tble') {

                $data = FakePostData::getFakeTravelPostForTable($travel_item->slug);
                $response = $this->post('/api/admin/create-post-for-table', $data);
                $response->assertOk();
                $this->assertDatabaseHas($cat_name . '_posts', [
                    'slug' => $data['slug'],
                ]);
            } else {
                $data = FakePostData::getFakeSimplePost($cat_name);
                $response = $this->post('/api/admin/create-post-single', $data);
                $response->assertOk();
                $this->assertDatabaseHas($cat_name . '_menu', [
                    'slug' => $data['slug'],
                ]);
            };
        } else {
            $data = FakePostData::getFakeSimplePost($cat_name);
            $response = $this->post('/api/admin/create-post-single', $data);
            $response->assertOk();
            $this->assertDatabaseHas($cat_name . '_menu', [
                'slug' => $data['slug'],
            ]);
        };
        dump('создан новый пост', $data);
        echo "Нажмите Enter...";
        fgets(STDIN);
        }
}
