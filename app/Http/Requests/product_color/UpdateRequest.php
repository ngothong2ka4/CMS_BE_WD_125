<?php

namespace App\Http\Requests\product_color;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateRequest extends FormRequest
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
    public function rules(Request $request): array
    {
        return [
            'name' => 'required|max:255|min:2|regex:/^[a-zA-Z ]*$/|unique:attribute_color,name,' . $request->id
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Màu sản phẩm là bắt buộc.',
            'name.max' => 'Màu sản phẩm không được vượt quá :max ký tự.',
            'name.min' => 'Màu sản phẩm phải có ít nhất :min ký tự.',
            'name.regex' => 'Tên màu sản phẩm không thể chứa số và ký tự đặc biệt',
            'name.unique' => 'Màu sản phẩm đã tồn tại'
        ];
    }
}
