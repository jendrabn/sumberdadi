<?php

namespace App\Http\Requests\Admin\Stores;

use Illuminate\Foundation\Http\FormRequest;

class StoreStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'community_id' => ['required', 'numeric', 'exists:communities,id'],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'city_id' => ['required', 'numeric', 'exists:indonesia_cities,id'],
            'province_id' => ['required', 'numeric', 'exists:indonesia_provinces,id'],
            'store_image' => ['required', 'image'],
            'phone' => ['required', 'starts_with:62'],
            'verified_at' => ['nullable', 'date_format:Y-m-d\TH:i']
        ];
    }
}
