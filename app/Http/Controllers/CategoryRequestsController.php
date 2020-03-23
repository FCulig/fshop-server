<?php

namespace App\Http\Controllers;

use App\CategoryGroup;
use App\CategoryRequest;
use App\Http\Resources\CategoryResource as CategoryRequestResource;
use Illuminate\Http\Request;

class CategoryRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CategoryRequest::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categoryRequest = new CategoryRequest;

        $categoryRequest->name = $request->input('name');
        $categoryRequest->resolved = false;
        $categoryRequest->group_id = $request->input('group_id');

        if ($categoryRequest->save()) {
            return new CategoryRequestResource($categoryRequest);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new CategoryRequestResource(CategoryRequest::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function acceptRequest(Request $request, $id)
    {
        $categoryRequest = CategoryRequest::findOrFail($id);

        $categoryRequest->resolved = true;

        if ($categoryRequest->save()) {
            $response = app('App\Http\Controllers\CategoriesController')->addFromCategoryRequest($categoryRequest);
            return $response;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoryRequest = CategoryRequest::findOrFail($id);

        if ($categoryRequest->delete()) {
            return new CategoryRequestResource($categoryRequest);
        }
    }
}
