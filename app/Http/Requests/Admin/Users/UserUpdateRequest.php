<?php

namespace App\Http\Requests\Admin\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->hasRole('admin') || $this->user()->hasPermission('manage all users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['string', 'max:255', 'nullable'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['nullable', 'string', 'min:8'],
            'role_id' => ['required', 'array'],
        ];
    }

    public function validated()
    {
        $validated = parent::validated();
        if (!$this->request->get('password')) {
            unset($validated['password']);
            return $validated;
        }

        $validated['password'] = Hash::make($this->request->get('password'));

        return $validated;
    }

}
