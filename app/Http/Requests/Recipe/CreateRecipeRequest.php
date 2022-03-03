<?php

namespace App\Http\Requests\Recipe;

use Illuminate\Foundation\Http\FormRequest;

class CreateRecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'description' => 'required',
            'featured_image' => 'required|image',
            'additional_images' => 'array',
            'additional_images.*' => 'nullable|image',
            'type' => 'required|in:sweet,salty',
            'preparation_time' => 'required|in:30,30-60,60-120,120-180,180',
            'preparation_level' => 'required|in:easy,medium,hard',
            'ingredients' => 'required|array|filled',
            'ingredients.*' => 'required|string'
        ];
    }
}
