<?php

namespace App\Http\Requests\Admin\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
                $rule_thumb_img = 'url';
                break;
            default:
                $rule_thumb_img = 'required|url';
        }
        return [
            'title' => 'required|min:6|max:255',
            'category_id' => 'array',
            'category_id.*' => 'numeric',
            'thumb_img' => $rule_thumb_img,
            'published' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được để trống',
            'min' => ':attribute phải lớn hơn :min ký tự',
            'max' => ':attribute không quá :max ký tự',
            'regex' => ':attribute không đúng định dạng ảnh',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Tiêu đề',
            'category_id' => 'Danh mục',
            'thumb_img' => 'Ảnh đại diện'
        ];
    }
}
