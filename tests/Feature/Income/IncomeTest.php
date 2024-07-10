<?php

namespace Tests\Feature\Income;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncomeTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setup(): void 
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }
    /**
     * A basic feature test example.
     */
    public function test_income_page_render()
    {
       $response = $this->actingAs($this->user)->get(route('income.index'));

       $response->assertSee('See Index Page');
    }

    
}
