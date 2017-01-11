<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Storage;

class AssetController extends ApiController
{
    public function upload(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|max:20000'
        ]);

        $image = $request->file('image');
        if ($image->isValid()) {
            $name = $image->getClientOriginalName();
            $image->storeAs('public/images', $name);
            return response()->json(['link' => url(Storage::url('images/'.$name))], REST_CREATE_SUCCESS);
        }
        return response()->json(['message' => trans('app.upload_image_fail'), 'errors' => ['image' => trans('app.invalid_image')]], REST_BAD_REQUEST);
    }
}
