<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('image', function ($query) {
                return "<img width='70px' src='" . asset($query->thumb_image) . "'></img>";
            })
            ->addColumn('type', function ($query) {
                switch ($query->product_type) {
                    case 'new_arrival':
                        return '<i class="badge badge-warning">New Arrival</i>';
                    case 'featured_product':
                        return '<i class="badge badge-warning">Featured</i>';
                    case 'top_product':
                        return '<i class="badge badge-info">Top Product</i>';
                    case 'best_product':
                        return '<i class="badge badge-success">Best Product</i>';
                    default:
                        return '<i class="badge badge-secondary">None</i>';
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
                $editBtn = "<a href='" . route('admin.product.edit', $query->id) . "' class='btn btn-primary'><i class='far fa-edit'></i></a>";
                $deleteBtn = "<a href='" . route('admin.product.destroy', $query->id) . "' class='btn btn-danger ml-2 delete-item'><i class='fas fa-trash-alt'></i></a>";
                $moreBtn = '<div class="dropdown dropleft d-inline">
                <button class="btn btn-primary dropdown-toggle ml-1" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-cog"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item has-icon" href="' . route('admin.image-gallery.index', ['product_id' => $query->id]) . '"><i class="far fa-heart"></i> Image Gallery</a>
                    <a class="dropdown-item has-icon" href="' . route('admin.variant.index', ['product_id' => $query->id]) . '"><i class="far fa-file"></i> Variants</a>
                </div>
              </div>';
                return $editBtn . $deleteBtn . $moreBtn;
            })
            ->rawColumns(['image', 'type', 'status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('products-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
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
            Column::make('id'),
            Column::make('image'),
            Column::make('name'),
            Column::make('price'),
            Column::make('type'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(200)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Products_' . date('YmdHis');
    }
}
