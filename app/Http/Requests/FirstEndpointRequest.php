<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FirstEndpointRequest extends FormRequest
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
            'OrderId' => ['required', 'integer', 'min:1'],
            'OrderCode' => ['required', 'string', 'max:20'],
            'OrderDate' => ['required', 'date'],
            'TotalAmountWithoutDiscount' => ['required', 'numeric'],
            'TotalAmountWithDiscount' => ['required', 'numeric'],
        ];
    }
}
