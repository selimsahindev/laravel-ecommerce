<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\BrandsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    use ImageUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(BrandsDataTable $dataTable)
    {
        return $dataTable->render('admin.brand.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'logo' => ['image', 'required', 'image', 'max:2048'],
            'name' => ['required', 'max:255'],
            'is_featured' => ['required'],
            'status' => ['required'],
        ]);

        $brand = new Brand();

        $brand->logo = $this->uploadImage($request, 'logo', 'uploads/brands', $brand->logo);
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $brand->is_featured = $request->is_featured;
        $brand->status = $request->status;
        $brand->save();

        toastr('Brand created successfully');

        return redirect()->route('admin.brand.index');
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
        $brand = Brand::findOrFail($id);
        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'logo' => ['nullable', 'image', 'image', 'max:2048'],
            'name' => ['required', 'max:255', 'unique:brands,name,' . $id],
            'is_featured' => ['required'],
            'status' => ['required'],
        ]);

        $brand = Brand::findOrFail($id);

        /** Update the logo */
        $imagePath = $this->updateImage($request, 'logo', 'uploads/brands', $brand->logo);

        $brand->logo = empty(!$imagePath) ? $imagePath : $brand->logo;
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->name);
        $brand->is_featured = $request->is_featured;
        $brand->status = $request->status;
        $brand->save();

        toastr('Brand updated successfully');

        return redirect()->route('admin.brand.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Brand deleted successfully.'
        ]);
    }

    /** Change the active status of the brand. */
    public function changeStatus(Request $request)
    {
        $category = Brand::findOrFail($request->id);
        $category->status = $request->isChecked == 'true' ? 1 : 0;
        $category->save();

        return response(['message' => 'Status updated successfully!']);
    }
}
