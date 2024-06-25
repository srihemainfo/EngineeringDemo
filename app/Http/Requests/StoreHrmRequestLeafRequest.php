<?php

namespace App\Http\Requests;

use App\Models\HrmRequestLeaf;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreHrmRequestLeafRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('hrm_request_leaf_create');
    }

    public function rules()
    {
        return [
            'from_date' => [
                'string',
                'min:0',
                'max:15',
                'nullable',
            ],
            'to_date' => [
                'string',
                'min:0',
                'max:15',
                'nullable',
            ],
            'reason' => [
                'string',
                'nullable',
                'max:65535',
            ],
            'approved_by' => [
                'string',
                'min:0',
                'max:15',
                'nullable',
            ],
        ];
    }
}
