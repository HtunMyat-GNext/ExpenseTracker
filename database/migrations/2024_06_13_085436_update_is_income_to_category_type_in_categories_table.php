<?php

use App\Enums\CategoryType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->enum('type',[
                CategoryType::INCOME->value,
                CategoryType::EXPENSE->value,
                CategoryType::OTHERS->value
            ])->change();

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('is_income')->default(1);

            DB::table('categories')->update(['is_income' => DB::raw("CASE WHEN type = 'income' THEN 1 ELSE 0 END")]);

            $table->dropColumn('type');
        });
    }
};