<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SubCategoriesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SubCategoriesDataTable $dataTable)
    {
        return $dataTable->render('admin.sub-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.sub-category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'max:200', 'unique:sub_categories,name'],
            'status' => ['required']
        ]);

        $subCategory = new SubCategory();
        $subCategory->category_id = $request->category_id;
        $subCategory->name = $request->name;
        $subCategory->slug = Str::slug($request->name);
        $subCategory->status = $request->status;
        $subCategory->save();

        toastr('Sub Category created successfully');

        return redirect()->route('admin.sub-category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::all();
        $subCategory = SubCategory::findOrFail($id);
        return view('admin.sub-category.edit', compact('subCategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'max:200', 'unique:sub_categories,name,' . $id],
            'status' => ['required']
        ]);

        $subCategory = SubCategory::findOrFail($id);

        $subCategory->category_id = $request->category_id;
        $subCategory->name = $request->name;
        $subCategory->slug = Str::slug($request->name);
        $subCategory->status = $request->status;
        $subCategory->save();

        toastr('Sub category updated successfully');

        return redirect()->route('admin.sub-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $childCategoryCount = $subCategory->childCategories->count();

        if ($childCategoryCount > 0) {
            return response([
                'status' => 'error',
                'message' => 'This sub category has child categories. Please delete them first!'
            ]);
        }

        $subCategory->delete();

        return response([
            'status' => 'success',
            'message' => 'Sub category deleted successfully!'
        ]);
    }

    /** Change the active status of the sub-category. */
    public function changeStatus(Request $request)
    {
        $subCategory = SubCategory::findOrFail($request->id);
        $subCategory->status = $request->isChecked == 'true' ? 1 : 0;
        $subCategory->save();

        return response(['message' => 'Status updated successfully!']);
    }

    /** Get the child categories of the sub category. */
    public function getChildCategories(Request $request)
    {
        $category = SubCategory::findOrFail($request->id);
        return $category->childCategories;
    }
}
