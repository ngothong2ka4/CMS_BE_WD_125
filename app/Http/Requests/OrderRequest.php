<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderRequest extends FormRequest
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
            'recipient_name' => 'required|min:2|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|regex:/^0[1-9]{1}[0-9]{8}$/',
            'recipient_address' => 'required|min:2|max:255',
            'note' => 'nullable|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'recipient_name.required' => 'Tên người nhận là bắt buộc.',
            'recipient_name.min' => 'Tên người nhận phải có ít nhất :min ký tự.',
            'recipient_name.max' => 'Tên người nhận không được vượt quá :max ký tự.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.max' => 'Email không được vượt quá :max ký tự.',
            'phone_number.required' => 'Số điện thoại là bắt buộc.',
            'phone_number.regex' => 'Số điện thoại không hợp lệ.',
            'recipient_address.required' => 'Địa chỉ nhận hàng là bắt buộc.',
            'recipient_address.min' => 'Địa chỉ nhận hàng phải có ít nhất :min ký tự.',
            'recipient_address.max' => 'Địa chỉ nhận hàng không được vượt quá :max ký tự.',
            'note.max' => 'Ghi chú không được vượt quá :max ký tự.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Dữ liệu không hợp lệ',
            'errors' => $validator->errors()
        ], 422));
    }
}
