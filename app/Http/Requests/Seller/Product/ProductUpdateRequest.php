<?php

namespace App\Http\Requests\Seller\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('seller');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'product_category_id' => ['required', 'numeric', 'exists:product_categories,id'],
            'price' => ['required', 'numeric'],
            'stock' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
            'extra_keys' => ['required_with:extra_values', 'nullable', 'array'],
            'extra_values' => ['required_with:extra_keys', 'nullable', 'array'],
            'slug' => ['required'],
            'extra_info' => ['nullable'],
        ];
    }

    /**
     * @return array|void
     */
    public function validationData()
    {
        $this->request->add([
            'slug' => Str::slug($this->request->get('name')),
            'extra_info' => array_combine($this->request->get('extra_keys', []), $this->request->get('extra_values', []))
        ]);
        return $this->all();
    }
}
