<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
                $rule = [
                    'role' => 'required|array',
                    'role.*' => 'numeric'
                ];
                break;
            default:
                $rule = [
                    'full_name' => 'required|string',
                    'email' => 'required|email|unique:admins,email,'.$this->input('id'),
                    'role' => 'required|array',
                    'role.*' => 'numeric'
                ];
        }
        return $rule;
    }
}
