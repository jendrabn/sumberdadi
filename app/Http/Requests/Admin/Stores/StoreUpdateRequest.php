<?php

namespace App\Http\Requests\Admin\Stores;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'alpha_dash'],
            'address' => ['required', 'string'],
            'store_image' => ['nullable', 'image'],
            'phone' => ['required', 'starts_with:62'],
            'verified_at' => ['nullable', 'date_format:Y-m-d\TH:i']
        ];
    }
}
