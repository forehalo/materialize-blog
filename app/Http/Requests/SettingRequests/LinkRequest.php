<?php

namespace App\Http\Requests\SettingRequests;

use App\Http\Requests\Request;

class LinkRequest extends Request
{
    protected $redirect = '/settings#link';

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
            //
        ];
    }
}
