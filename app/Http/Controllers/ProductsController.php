<?php

namespace App\Http\Controllers;

use App\Http\Resources\Transaction;
use App\Product;
use App\ProductImage;
use App\Transcation;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::all()->where('quantity', '>', 0);

        if ($request->query('category')) {
            $products = $products->where('category_id', $request->query('category'));
        }

        if ($request->query('min-price')) {
            $products = $products->where('price', ">=", $request->query('min-price'));
        }

        if ($request->query('max-price')) {
            $products = $products->where('price', "<=", $request->query('max-price'));
        }

        $productsResources = array();
        foreach ($products as $product) {
            $productsResources[] = new \App\Http\Resources\Product($product);
        }

        return $productsResources;
    }

    private function getFileName($request)
    {
        $filenameWithExt = $request->file('product_images')->getClientOriginalName();

        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('product_images')->getClientOriginalExtension();

        return $filename . '_' . time() . '.' . $extension;
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
        return new \App\Http\Resources\Product($this->getProductWithId($id));
    }

    public function getProductWithId($id)
    {
        return Product::findOrFail($id);
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
            if ($request->hasFile('product_images')) {
                $productImagesController = new ProductImagesController;
                $productImagesController->deleteImages($id);
                $this->saveImages($request->file('product_images'), $product->id);
            }

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

    private function saveImages($images, $productId)
    {
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

    public function buyProduct($productId, $quantity)
    {
        $product = $this->getProductWithId($productId);

        if ($product->quantity >= $quantity) {
            $product->quantity = $product->quantity - $quantity;
            if ($product->save()) {
                return true;
            }
        } else {
            return false;
        }
    }

    public function restock(Request $request, $id)
    {
        $product = $this->getProductWithId($id);
        $product->quantity = $request->input('quantity');

        if ($product->save()) {
            return new \App\Http\Resources\Product($product);
        }
    }

    public function profit($id)
    {
        $transactions = User::findOrFail($id)->transactions->where('status_id', '3');

        $total = $this->calculateProfit($transactions);
        $date = Carbon::today()->subDays(30);
        $transactions = $transactions->where('created_at', '>=', $date);
        $month = $this->calculateProfit($transactions);
        $date = Carbon::today()->subDays(7);
        $transactions = $transactions->where('created_at', '>=', $date);
        $week = $this->calculateProfit($transactions);

        return response()->json([
            "total" => $total,
            "month" => $month,
            "week" => $week
        ]);
    }

    private function calculateProfit($transactions)
    {
        $profit = (float)0;
        $productsController = new ProductsController;
        foreach ($transactions as $transaction) {
            $profit = $profit + (int)$transaction->quantity * (float)$productsController->getProductWithId($transaction->item_id)->price;
        }

        return $profit;
    }

    public function homePageProducts(Request $request)
    {
        $popular = Transcation::select('item_id', DB::raw('sum(quantity) as quantity'))
            ->groupBy('item_id')
            ->orderBy('quantity', 'desc')
            ->limit(5)
            ->get();
        $popular = $this->addProducts($popular);

        return response()->json([
            "popular" => $popular
        ]);
    }

    private function addProducts($transactions){
        foreach ($transactions as $item){
            $item->product = new \App\Http\Resources\Product(Product::findOrFail($item->item_id));
        }

        return $transactions;
    }
}
