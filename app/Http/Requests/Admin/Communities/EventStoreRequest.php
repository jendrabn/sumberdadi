<?php

namespace App\Http\Requests\Admin\Communities;

use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
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
            'image' => ['required', 'image'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string'],
            'max_attendees' => ['nullable', 'numeric'],
            'started_at' => ['required', 'date_format:Y-m-d\TH:i'],
            'ended_at' => ['required', 'date_format:Y-m-d\TH:i']
        ];
    }
}
