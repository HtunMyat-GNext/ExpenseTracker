<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * A basic feature test example.
     */
    public function test_categories_index_page_render()
    {
        $response = $this->actingAs($this->user)->get(route('categories.index'));
        $response->assertStatus(200);
        $response->assertSee('See Your Categories');
    }

    /**
     * Test for creating a category.
     */
    public function test_category_create_render()
    {
        $this->actingAs($this->user);
        $this->withSession(['_token' => csrf_token()]);
        $response = $this->post(route('categories.store'), [
            '_token' => csrf_token(),
            'title' => 'test category',
            'type' => 'expense',
            'color' => '#863c3b',
        ]);

        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', [
            'title' => 'test category',
            'type' => 'expense',
            'color' => '#863c3b',
        ]);
    }

    /**
     * Test for updating a category.
     */
    public function test_category_update_render()
    {
        $this->actingAs($this->user);
        $category = Category::factory()->create([
            'user_id' => $this->user->id, 
            'title' => 'test category',
            'type' => 'expense',
            'color' => '#863c3b',
        ]);
        $response = $this->put(route('categories.update', $category->id), [
            '_token' => csrf_token(),
            'title' => 'Book Update',
            'type' => 'expense',
            'color' => '#863c3e',
        ]);
        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'title' => 'Book Update',
            'type' => 'expense',
            'color' => '#863c3e',
        ]);
    }

    /**
     * Test for deleting a category.
     */
    public function test_category_delete_render()
    {
        $this->actingAs($this->user);
        $category = Category::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->delete(route('categories.destroy', $category->id));
        $response->assertRedirect(route('categories.index'));
        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }
}
