<?php

namespace App\Http\Requests\Admin\Categories;

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
        $method = $this->method();
        switch ($method){
            case 'PUT':
            case 'PATCH':
                $rule_parent_id = 'numeric';
                $rule_thumb_img = 'image|mimes:jpeg,png,jpg,gif,svg|max:10240';
                break;
            default:
                $rule_parent_id = 'required|numeric';
                $rule_thumb_img = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240';
        }
        return [
            'name' => 'required|min:6|max:255||unique:categories,name,'.$this->input('id'),
            'parent_id' => $rule_parent_id,
            'thumb_img' => $rule_thumb_img
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
            'image' => ':attribute phải đúng định dạng ảnh',
            'unique' => ':attribute đã tồn tại trên hệ thống'
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
