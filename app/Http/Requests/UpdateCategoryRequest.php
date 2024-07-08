<?php

namespace App\Http\Requests;

use App\Enums\CategoryType;
use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'title' => 'required|string',
            
            'type' => [
                'required',
                
                 'in:' . implode(',', $categoryTypes),
                 function ($attribute, $value, $fail) {
                    // dd($this->input('title'));
                    $exists = Category::where('title', $this->input('title'))
                       ->where('type', $value)
                      ->where('id', '<>', $this->route('category'))
                       ->exists();
                   if ($exists) {
                       $fail('This category with the same title and type already exists. Please create a new category.');
                   }
                 },
            ],
            
        ];
    }
}

