<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Product;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        if(Product::findOrFail($id) != null){
            $comment = new Comment($request->all());
            $comment->product_id = $id;

            if($comment->save()){
                return new \App\Http\Resources\Comment($comment);
            }
        }
    }

    public function commentsOnProduct(Request $request, $id){
        $comments  = Product::findOrFail($id)->comments;
        $commentsResource = array();

        foreach ($comments as $comment){
            $commentsResource[] = new \App\Http\Resources\Comment($comment);
        }

        return $commentsResource;
    }

    public function commentsOnProductFN($id){
        return Product::findOrFail($id)->comments;
    }

    public function show($id){
        return Comment::findOrFail($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if($comment->delete()){
            return new \App\Http\Resources\Comment($comment);
        }
    }

    public function latestCommentsOnUsersProducts($id){
        $usersController = new UsersController;
        $ids = $usersController->getUserWithId($id)->products->pluck('id');
        $comments = Comment::whereIn('product_id', $ids)->orderBy('created_at', 'asc')->limit(5)->get();
        $commentsResources = array();

        foreach ($comments as $comment){
            $commentsResources[] = new \App\Http\Resources\Comment($comment);
        }

        return $commentsResources;
    }
}
