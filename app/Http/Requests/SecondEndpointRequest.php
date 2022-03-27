<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SecondEndpointRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', 'integer', 'min:1'],
            'code' => ['required', 'string', 'max:20'],
            'date' => ['required', 'date'],
            'total' => ['required', 'numeric'],
            'discount' => ['required', 'numeric'],
        ];
    }
}
