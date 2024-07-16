<?php

namespace Tests\Feature\Income;

use App\Models\Category;
use App\Models\Income;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncomeTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $category;

    protected function setup(): void 
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->category = Category::factory()->create(['user_id' => $this->user->id]);
    }
    /**
     * income page render.
     */
    public function test_income_page_render()
    {
       $response = $this->actingAs($this->user)->get(route('income.index'));

       $response->assertSee('Let\'s See Your Incomes');
    }

    /**
     * Test for creating income . 
     * img created with fake.
     */

     public function test_income_create_render()
     {
        $file = UploadedFile::fake()->image('photo.jpg');

        $response = $this->actingAs($this->user)->post(route('income.store'),[
            'title'=>'Salary',
            'amount'=>3000000,
            'user_id' => $this->user->id,
            'image' => $file,
            'date' => now()->toDateString(),
            'category_id' => $this->category->id
        ]);

        $response->assertRedirect(route('income.index'));
        $this->assertDatabaseHas('incomes',[
            'title' => 'Salary',
            'amount' => 3000000,
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'date' => now()->toDateString(),
        ]);
     }
        /**
         * update test for income
         */

         public function test_income_update_render()
         {
            $incomes = Income::factory()->create([
                'title' => 'Old Salary',
            'amount' => 2000000,
            'user_id' => $this->user->id,
            'date' => now()->subMonth()->toDateString(),
            'category_id' => $this->category->id,
            ]);
            /**
             * new data for update
             */
            $newFile = UploadedFile::fake()->image('new_photo.jpg');
            $newTitle = 'Updated Salary';
            $newAmount = 4000000;
            $newDate = now()->toDateString();

            $response = $this->actingAs($this->user)->put(route('income.update', $incomes->id),[
            'title' => $newTitle,
            'amount' => $newAmount,
            'date' => $newDate,
            'image' => $newFile,
            'category_id' => $this->category->id,
            ]);

            $response->assertRedirect(route('income.index'));
            $this->assertDatabaseHas('incomes',[
            'id' => $incomes->id,
            'title' => $newTitle,
            'amount' => $newAmount,
            'date' => $newDate,
            'category_id' => $this->category->id,
            ]);


         }

         /**
          * delete test for incomes
          */
          public function test_income_delete_render()
          {
            $incomes = Income::factory()->create([
                'title' => 'Delete Me',
                'amount' => 1500000,
                'user_id' => $this->user->id,
                'date' => now()->toDateString(),
                'category_id' => $this->category->id,
            ]);

            $response = $this->actingAs($this->user)->delete(route('income.destroy', $incomes->id));
            $response->assertRedirect(route('income.index'));
            $this->assertDatabaseMissing('incomes',[
                'id' => $incomes->id,
            ]);
          }
}
