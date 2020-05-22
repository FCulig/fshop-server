<?php

namespace App\Http\Controllers;

use App\Category;
use App\CategoryGroup;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $categoriesResources = array();

        foreach ($categories as $cat){
            $categoriesResources[] = new CategoryResource($cat);
        }
        return $categoriesResources;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category;

        $category->name = $request->input('name');
        $category->group_id = $request->input('group_id');

        if ($category->save()) {
            return new CategoryResource($category);
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
        return new CategoryResource(Category::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->id = $id;
        $category->name = $request->input('name');
        $category->group_id = $request->input('group_id');

        if ($category->save()) {
            return new CategoryResource($category);
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
        $category = Category::findOrFail($id);

        $category->delete();

        return new CategoryResource($category);
    }

    /**
     * Accept users category request.
     *
     * @param  CategoryRequest  $id
     * @return \Illuminate\Http\Response
     */
    public function addFromCategoryRequest($request)
    {
        $category = new Category;

        $category->name = $request->name;
        $category->group_id = $request->group_id;

        if ($category->save()) {
            return new CategoryResource($category);
        }
    }
}
