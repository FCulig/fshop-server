<?php

namespace App\Http\Controllers;

use App\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class ProductImagesController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param int $productId
     * @return \Illuminate\Http\Response
     */
    public function getProductImages($productId)
    {
        return ProductImage::all()->where('product_id', '=', $productId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteImages($productId)
    {
        $productImages = ProductImage::all()->where('product_id', $productId);

        foreach ($productImages as $img) {
            File::delete(public_path("/storage/images/product-images/" . $img->url));
        }

        if (ProductImage::where('product_id', $productId)->delete()) {
            return $productImages;
        }
    }

    public function deleteImage($id)
    {
        $img = ProductImage::findOrFail($id);
        if ($img->delete()) {
            File::delete(public_path("/storage/images/product-images/" . $img->url));

            return $img;
        }
    }
}
