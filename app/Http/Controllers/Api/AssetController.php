<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Storage;

class AssetController extends ApiController
{
    protected $disk;

    public function __construct()
    {
        // no root permissions.
        // $link = public_path('storage');
        // if (@linkinfo($link) === -1) {
        //     symlink(config('filesystems.disks.images.root'), $link);
        // }
        $this->disk = Storage::disk('images');
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|max:20000'
        ]);

        $image = $request->file('image');

        if ($image->isValid()) {
            $name = $image->getClientOriginalName();
            // check image existence
            if ($this->disk->exists($name)) {
                return response()->json([
                    'message' => trans('app.upload_image_fail'), 
                    'errors' => ['image' => trans('app.existent_image')]
                ], REST_BAD_REQUEST);
            }
            
            $image->storeAs('', $name, 'images');
            return response()->json(['link' => url($this->disk->url($name))], REST_CREATE_SUCCESS);
        }
        return response()->json([
            'message' => trans('app.upload_image_fail'), 
            'errors' => ['image' => trans('app.invalid_image')]
        ], REST_BAD_REQUEST);
    }
}
