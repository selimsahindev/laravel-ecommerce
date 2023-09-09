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
        $product = $variant->product;
        return $dataTable->render('admin.product.variant-item.index', compact(['product', 'variant']));
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

    public function edit(string $variantId, string $id)
    {
        $variantItem = ProductVariantItem::findOrFail($id);
        $variant = ProductVariant::findOrFail($variantId);
        return view('admin.product.variant-item.edit', ['variant' => $variant, 'variant_item' => $variantItem]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'variant_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer'],
            'is_default' => ['required'],
            'status' => ['required']
        ]);

        $variantItem = ProductVariantItem::findOrFail($request->id);
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
}
