<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testGetCategoriesWithProducts()
    {
        $this->get('/categories')->assertSeeText("Samsung");
    }
}
