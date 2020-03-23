<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductImage;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product;

        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->quantity = $request->input('quantity');
        $product->price = $request->input('price');
        $product->user_id = $request->input('user_id');
        $product->category_id = $request->input('category_id');

        if ($product->save()) {
            $this->saveImages($request->file('product_images'), $product->id);

            //TODO: vracanje liste slika
            return new \App\Http\Resources\Product($product);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::with('productImages')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->id = $id;
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->quantity = $request->input('quantity');
        $product->price = $request->input('price');
        $product->user_id = $request->input('user_id');
        $product->category_id = $request->input('category_id');

        if ($product->save()) {
            //TOOD: obrisi stare slike prije ovog
            $this->saveImages($request->file('product_images'), $product->id);

            return new \App\Http\Resources\Product($product);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->delete()) {
            $productImagesController = new ProductImagesController;
            $productImagesController->deleteImages($id);
            return new \App\Http\Resources\Product($product);
        }
    }

    private function saveImages($images, $productId){
        foreach ($images as $img) {
            $filenameWithExt = $img->getClientOriginalName();

            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $img->getClientOriginalExtension();

            $filenameToStore = $filename . '_' . time() . '.' . $extension;

            $productImage = new ProductImage;
            $productImage->url = $filenameToStore;
            $productImage->product_id = $productId;

            $productImage->save();

            $img->storeAs('public/images/product-images', $filenameToStore);
        }
    }
}
