<?php

namespace App\Http\Requests;

use App\Models\Events;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEventsRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('events_create');
    }

    public function rules()
    {
        return [
            'event' => [
                'string',
                'min:1',
                'max:191',
                'nullable',
            ],
        ];
    }
}
