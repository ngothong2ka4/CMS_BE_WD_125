<?php

namespace App\Http\Requests\product_color;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','max:255']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Màu sản phẩm là bắt buộc.',
            'name.max' => 'Màu sản phẩm không được vượt quá :max ký tự.'
        ];
    }
}
