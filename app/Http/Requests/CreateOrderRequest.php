<?php

namespace App\Http\Requests;

use App\Rules\GreaterThanZero;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
        // TODO: change "orders" to "products"
        return [
            'orders.*.article_code' => ['required', 'string', 'between:1,20'],
            'orders.*.article_name' => ['required', 'string', 'between:1,20'],
            'orders.*.unit_price' => ['required', 'numeric', new GreaterThanZero() ],
            'orders.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }
}
