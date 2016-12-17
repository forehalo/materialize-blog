<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

abstract class ApiController extends Controller
{
    /**
     * Validate the given request with the given rules.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  array $rules
     * @param  array $messages
     * @param  array $customAttributes
     * @throws HttpResponseException
     */
    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        $validator = $this->getValidationFactory()->make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            $errors = $validator->errors()->getMessages();
            $unique = [];

            foreach ($errors as $key => $messages) {
                $unique[$key] = array_shift($messages);
            }

            throw new HttpResponseException(
                response()->json([
                    'message' => trans('app.form_invalid'),
                    'errors' => $unique
                ], REST_INVALID_FIELDS)
            );
        }
    }
}
