<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'shipping_name' => ['required', 'string', 'max:255'],
            'shipping_province_id' => ['required', 'numeric', 'exists:indonesia_provinces,id'],
            'shipping_city_id' => ['required', 'numeric', 'exists:indonesia_cities,id'],
            'shipping_address' => ['required', 'string'],
            'shipping_zipcode' => ['required', 'max:12'],
            'shipping_phone' => ['required', 'numeric', 'starts_with:62'],
            'shipping_methods' => ['required', 'array'],
            'shipping_services' => ['required', 'array'],
            'payment_method' => ['required', 'string', 'in:bank,ewallet'],
            'account_number' => ['required_if:payment_method,bank', 'nullable', 'numeric'],
            'bank' => ['required_if:payment_method,bank', 'nullable', 'string'],
            'phone_number' => ['required_if:payment_method,ewallet', 'nullable', 'starts_with:62'],
            'ewallet' => ['required_if:payment_method,ewallet', 'nullable', 'string'],
            'description' => ['nullable', 'string']
        ];
    }
}
