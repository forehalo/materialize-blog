<?php

namespace App\Http\Requests\SettingRequests;

use App\Http\Requests\Request;

class ProfileRequest extends Request
{
    protected $redirect = '/settings#profile';

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
            'title' => 'required|max:255',
            'name' => 'required|max:255',
            'card_title' => 'required|max:255',
            'notice' => 'required|max:255',
            'url' => 'required',
        ];
    }
}
