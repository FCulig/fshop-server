<?php

namespace App\Http\Controllers;

use App\ProductImage;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    public function profilePicture($name)
    {
        $pathToFile = storage_path('/app/public/images/profile-pictures/' . $name);
        return response()->file($pathToFile);
    }

    public function productImage($id)
    {
        $productImg = ProductImage::findOrFail($id);
        $pathToFile = storage_path('/app/public/images/product-images/' . $productImg->url);
        return response()->file($pathToFile);
    }
}
