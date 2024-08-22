<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoriesTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function routes_are_registered()
    {
        $this->assertFileExists(base_path('routes/categoriesss.php'));
    }
}
