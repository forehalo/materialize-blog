<?php

namespace App\Http\Requests\SettingRequests;

use App\Http\Requests\Request;

class AuthRequest extends Request
{
    protected $redirect = '/settings#auth';

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
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'confirmed|alpha_num|min:6|max:25',
        ];
    }
}
