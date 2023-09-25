<?php

namespace App\DataTables;

use App\Models\ProductVariantItem;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductVariantItemsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('variant_name', function ($query) {
                return $query->productVariant->name;
            })
            ->addColumn('is_default', function ($query) {
                switch ($query->is_default) {
                    case '1':
                        return '<i class="badge badge-success">Yes</i>';
                    case '0':
                        return '<i class="badge badge-warning">No</i>';
                }
            })
            ->addColumn('status', function ($query) {
                $checked = $query->status == 1 ? 'checked' : '';

                $button = '<label class="custom-switch mt-2">
                    <input type="checkbox" ' . $checked . ' data-id="' . $query->id . '" name="custom-switch-checkbox" class="custom-switch-input change-status">
                    <span class="custom-switch-indicator"></span>
                </label>';

                return $button;
            })
            ->addColumn('action', function ($query) {
                $editBtn = "<a href='" . route('admin.variant-item.edit', ['variant_id' => $query->productVariant->id, 'id' => $query->id]) . "' class='btn btn-primary'><i class='far fa-edit'></i></a>";
                $deleteBtn = "<a href='" . route('admin.variant-item.destroy', $query->id) . "' class='btn btn-danger ml-2 delete-item'><i class='fas fa-trash-alt'></i></a>";

                return $editBtn . $deleteBtn;
            })
            ->rawColumns(['is_default', 'status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductVariantItem $model): QueryBuilder
    {
        return $model->where('product_variant_id', request()->variant_id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('productvariantitems-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(0)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->width(80),
            Column::make('name'),
            Column::make('variant_name'),
            Column::make('price'),
            Column::make('is_default'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ProductVariantItems_' . date('YmdHis');
    }
}
