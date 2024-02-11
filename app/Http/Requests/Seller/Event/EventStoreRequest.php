<?php

namespace App\Http\Requests\Seller\Event;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class EventStoreRequest extends FormRequest
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

    /**
     * @return array|void
     */
    public function validationData()
    {
        if ($this->request->get('max_attendees') === null) {
            $this->request->set('max_attendees', 10000);
        }
        $this->request->set('community_id', auth()->user()->community->id);
        return $this->all();
    }
}
