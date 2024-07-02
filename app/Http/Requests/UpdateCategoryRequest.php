<?php

namespace App\Http\Requests;

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
        return [
            'title' => 'required',
            'type' => 
                'required',
                
                function ($attribute, $value, $fail) {
                    $exists = Category::where('title', $this->title)
                        ->where('type', $value)
                        ->where('id', '<>', $this->route('category'))
                        ->exists();
                    if ($exists) {
                        $fail('This category with the same title and type already exists.Please create new category. ');
                    }
                },
            
            'color' => 'required|string',
        ];
    }
}
