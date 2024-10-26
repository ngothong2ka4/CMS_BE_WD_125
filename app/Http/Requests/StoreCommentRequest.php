<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
    public function rules()
    {
        return [
            'id_order' => 'required|exists:order,id',
            'id_product' => 'required|exists:products,id', 
            'id_variant' => 'required|exists:variants,id', 
            'content' => 'required|string|max:500', 
            'rating' => 'required|integer|min:1|max:5', 
        ];
    }

    public function messages()
    {
        return [
            'id_order.required' => 'Trường id_order là bắt buộc.',
            'id_order.exists' => 'Giá trị của id_order không tồn tại trong bảng orders.',
            'id_product.required' => 'Trường id_product là bắt buộc.',
            'id_product.exists' => 'Giá trị của id_product không tồn tại trong bảng products.',
            'id_variant.required' => 'Trường id_variant là bắt buộc.',
            'id_variant.exists' => 'Giá trị của id_variant không tồn tại trong bảng variants.',
            'content.required' => 'Trường content là bắt buộc.',
            'content.string' => 'Content phải là chuỗi ký tự.',
            'content.max' => 'Content không được vượt quá 500 ký tự.',
            'rating.required' => 'Trường rating là bắt buộc.',
            'rating.integer' => 'Rating phải là số nguyên.',
            'rating.min' => 'Rating phải từ 1 đến 5.',
            'rating.max' => 'Rating phải từ 1 đến 5.',
        ];
    }
}
