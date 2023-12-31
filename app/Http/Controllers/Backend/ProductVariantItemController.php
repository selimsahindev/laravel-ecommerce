<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductVariantItemsDataTable;
use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;
use Illuminate\Http\Request;

class ProductVariantItemController extends Controller
{
    public function index(ProductVariantItemsDataTable $dataTable, string $variantId)
    {
        $variant = ProductVariant::findOrFail($variantId);
        return $dataTable->render('admin.product.variant-item.index', compact(['variant']));
    }

    public function create(string $variantId)
    {
        $variant = ProductVariant::findOrFail($variantId);
        return view('admin.product.variant-item.create', compact('variant'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'variant_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer'],
            'is_default' => ['required'],
            'status' => ['required']
        ]);

        $variantItem = new ProductVariantItem();
        $variantItem->product_variant_id = $request->variant_id;
        $variantItem->name = $request->name;
        $variantItem->price = $request->price;
        $variantItem->is_default = $request->is_default;
        $variantItem->status = $request->status;
        $variantItem->save();

        toastr('Product variant item created successfully');

        return redirect()->route('admin.variant-item.index', $request->variant_id);
    }

    public function edit(string $id)
    {
        $variantItem = ProductVariantItem::findOrFail($id);
        return view('admin.product.variant-item.edit', compact('variantItem'));
    }

    public function update(Request $request)
    {
        $variantItem = ProductVariantItem::findOrFail($request->id);

        $request->validate([
            'variant_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer'],
            'is_default' => ['required'],
            'status' => ['required']
        ]);

        $variantItem->product_variant_id = $request->variant_id;
        $variantItem->name = $request->name;
        $variantItem->price = $request->price;
        $variantItem->is_default = $request->is_default;
        $variantItem->status = $request->status;
        $variantItem->save();

        toastr('Product variant item updated successfully');

        return redirect()->route('admin.variant-item.index', $request->variant_id);
    }

    public function destroy(string $id)
    {
        $variantItem = ProductVariantItem::findOrFail($id);
        $variantItem->delete();

        return response([
            'status' => 'success',
            'message' => 'Product variant item deleted successfully!'
        ]);
    }

    /** Change the active status of the variant item. */
    public function changeStatus(Request $request)
    {
        $variantItem = ProductVariantItem::findOrFail($request->id);
        $variantItem->status = $request->isChecked == 'true' ? 1 : 0;
        $variantItem->save();

        return response(['message' => 'Status updated successfully!']);
    }
}
