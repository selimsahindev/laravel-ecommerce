<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait ImageUploadTrait
{
    public function uploadImage(Request $request, String $inputName, String $path)
    {
        if ($request->hasFile($inputName)) {

            $image = $request->{$inputName};
            $imageName = 'media_' . uniqid() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path($path), $imageName);

            return $path . '/' . $imageName;
        }
    }
}
