<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordStoreRequest extends FormRequest
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
            'old_password' => 'required|min:6',
            'new_password' => 'required|min:6|confirmed'
        ];
    }


    public function messages()
    {
        return [
            'required' => ':attribute không được để trống',
            'min' => ':attribute phải lớn hơn :min ký tự',
            'confirmed' => ':attribute không khớp'
        ];
    }

    public function attributes()
    {
        return [
            'old_password' => 'Mật khẩu cũ',
            'new_password' => 'Mật khẩu mới'
        ];
    }
}
