<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use PhpParser\Node\Expr\Cast\String_;

trait ImageUploadTrait
{
    public function uploadImage(Request $request, String $inputName, String $path)
    {
        if ($request->hasFile($inputName)) {

            $image = $request->{$inputName};
            $imageName = $this->getUploadedImageName($image);

            $image->move(public_path($path), $imageName);

            return $path . '/' . $imageName;
        }
    }

    public function updateImage(Request $request, String $inputName, String $path, $oldPath = null)
    {
        if ($request->hasFile($inputName)) {

            // Remove the old image if exists
            if (File::exists(public_path($oldPath))) {
                File::delete(public_path($oldPath));
            }

            $image = $request->{$inputName};
            $imageName = $this->getUploadedImageName($image);

            $image->move(public_path($path), $imageName);

            return $path . '/' . $imageName;
        }
    }

    private function getUploadedImageName($image): String
    {
        return 'media_' . uniqid() . '.' . $image->getClientOriginalExtension();
    }
}
