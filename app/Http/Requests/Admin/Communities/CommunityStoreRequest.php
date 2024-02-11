<?php

namespace App\Http\Requests\Admin\Communities;

use Illuminate\Foundation\Http\FormRequest;

class CommunityStoreRequest extends FormRequest
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
            'name' => ['string', 'max:255', 'required'],
            'user_id' => ['required', 'numeric', 'exists:users,id'],
            'image' => ['required', 'image'],
            'description' => ['nullable', 'string'],
            'whatsapp' => ['nullable', 'numeric', 'starts_with:62', 'max:20'],
            'founded_at' => ['nullable', 'date'],
            'instagram' => ['nullable', 'alpha_dash', 'max:32'],
            'facebook' => ['nullable', 'url'],
            'is_active' => ['boolean']
        ];
    }

}
