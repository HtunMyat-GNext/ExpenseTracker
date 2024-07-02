<?php

namespace App\Http\Requests;

use App\Enums\CategoryType;
use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $categoryTypes = array_column(CategoryType::cases(), 'value');

        return [
            'title' => [
                'required',
                function ($attribute, $value, $fail) {
                    $exists = Category::where('title', $value)
                    ->where('type', $this->type)
                    ->exists();
                    if($exists) {
                        $fail('This category with the same title and type already exists.');
                    }
                },
            ],
            'type' => 'required|string',
            'color' => 'required',
        ];
    }
}
