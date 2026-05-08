<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryStartTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCategoryApiStart()
    {
        $response = $this->get('/api/categories');
        $response->assertOk();
        $response->assertJson(['data' =>[ ['id' => 1]]]);
    }
}
