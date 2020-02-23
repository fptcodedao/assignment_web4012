<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => 'required|min:6|max:255',
            'parent_id' => 'required|numeric',
            'thumb_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240'
        ];
    }

    /**
     * Custom messages
     * @return array
     */
    public function messages()
    {
        return [
            'required' => ':attribute không được để trống',
            'min' => ':attribute phải lớn hơn :min ký tự',
            'max' => ':attribute phải nhỏ hơn :max ký tự',
            'image' => ':attribute phải đúng định dạng ảnh'
        ];
    }

    /**
     * Custom attribute
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Tên danh mục',
            'parent_id' => 'Id Danh mục cha',
            'thumb_img' => 'Hình ảnh danh mục'
        ];
    }
}
