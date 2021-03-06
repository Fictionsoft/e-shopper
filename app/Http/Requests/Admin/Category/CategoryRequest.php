<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        switch ($this->method()){

            case 'POST':{
                return [
                    'name' => 'required|unique:categories',
                    'slug' => 'required|unique:categories',
                ];
            }

            case 'PUT' OR 'PATCH':{
                return [
                    'name' => 'required|unique:categories,name,'. $this->category->id,
                    'slug' => 'required|unique:categories,slug,'. $this->category->id,
                ];
            }
        }
    }
}
