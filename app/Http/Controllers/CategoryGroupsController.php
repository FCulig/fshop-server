<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CategoryGroup;
use App\Http\Resources\CategoryGroup as CategoryGroupResource;

class CategoryGroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CategoryGroup::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categoryGroup = new CategoryGroup;

        $categoryGroup->name = $request->input('name');

        if ($categoryGroup->save()) {
            return new CategoryGroupResource($categoryGroup);
        } else {
            // TODO: da se salje kod
            return response("There was an error while saving to database!", 500);
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
        return new CategoryGroupResource(CategoryGroup::findOrFail($id));
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
        $categoryGroup = CategoryGroup::findOrFail($id);

        $categoryGroup->id = $id;
        $categoryGroup->name = $request->input('name');

        if ($categoryGroup->save()) {
            return new CategoryGroupResource($categoryGroup);
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
        $categoryGroup = CategoryGroup::findOrFail($id);

        if ($categoryGroup->delete()) {
            return new CategoryGroupResource($categoryGroup);
        } else {
            //TODO:
        }
    }

    public function getCategoryGroupWithId($id){
        return CategoryGroup::findOrFail($id);
    }

    public function getCategoriesUnderGroup($id){
        $categoryGroup = $this->getCategoryGroupWithId($id);
        return $categoryGroup->categories;
    }
}
