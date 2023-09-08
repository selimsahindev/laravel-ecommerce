<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductVariantsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductVariantsDataTable $dataTable)
    {
        $product = Product::find(request()->product);
        return $dataTable->render('admin.product.variant.index', compact(['product']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.variant.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product' => ['integer', 'required'],
            'name' => ['required', 'max:200'],
            'status' => ['required']
        ]);

        $variant = new ProductVariant();
        $variant->product_id = $request->product;
        $variant->name = $request->name;
        $variant->status = $request->status;
        $variant->save();

        toastr('Variant created successfully', 'success', 'success');

        return redirect()->route('admin.variant.index', ['product' => $request->product]);
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
        $variant = ProductVariant::findOrFail($id);
        return view('admin.product.variant.edit', compact(['variant']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $variant = ProductVariant::findOrFail($id);
        $request->validate([
            'name' => ['required', 'max:200'],
            'status' => ['required']
        ]);

        $variant->name = $request->name;
        $variant->status = $request->status;
        $variant->save();

        toastr('Variant updated successfully', 'success', 'success');

        return redirect()->route('admin.variant.index', ['product' => $variant->product_id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $variant = ProductVariant::findOrFail($id);
        $variant->delete();

        return response([
            'status' => 'success',
            'message' => 'Variant deleted successfully!'
        ]);
    }

    /** Change the active status of the variant. */
    public function changeStatus(Request $request)
    {
        $variant = ProductVariant::findOrFail($request->id);
        $variant->status = $request->isChecked == 'true' ? 1 : 0;
        $variant->save();

        return response(['message' => 'Status updated successfully!']);
    }
}
