<?php

namespace App\Http\Requests\SettingRequests;

use App\Http\Requests\Request;

class ViewRequest extends Request
{
    protected $redirect = '/settings#view';

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
            'post_per_page' => 'required|numeric',
            'post_per_page_admin' => 'required|numeric',
            'comment_per_page_admin' => 'required|numeric',
            'hot_tags_count' => 'required|numeric',
        ];
    }
}
