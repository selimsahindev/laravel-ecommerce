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

    public function uploadMultipleImages(Request $request, String $inputName, String $path)
    {
        $imagePaths = [];

        if ($request->hasFile($inputName)) {

            $images = $request->{$inputName};

            foreach ($images as $image) {
                $imageName = $this->getUploadedImageName($image);
                $image->move(public_path($path), $imageName);

                $imagePaths[] = $path . '/' . $imageName;
            }

            return $imagePaths;
        }
    }

    public function updateImage(Request $request, String $inputName, String $path, $oldPath = null)
    {
        if ($request->hasFile($inputName)) {

            $this->deleteImage($oldPath);

            $image = $request->{$inputName};
            $imageName = $this->getUploadedImageName($image);

            $image->move(public_path($path), $imageName);

            return $path . '/' . $imageName;
        }
    }

    public function deleteImage(String $path)
    {
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }

    private function getUploadedImageName($image): String
    {
        return 'media_' . uniqid() . '.' . $image->getClientOriginalExtension();
    }
}
