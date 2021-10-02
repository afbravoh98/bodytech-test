<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithMapping, WithHeadings
{
    protected $orders;
    public function __construct($orders = null)
    {
        $this->orders = $orders;
    }

    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return $this->orders ?: Order::all();
    }

    public function map($row): array
    {
        $products = optional($row->details);

        $productsStr = '-';
        if ($products && $products->count() > 0) {
            $productsStr = $products->pluck('product_name')->implode(', ');
        }

        return [
            $row->id,
            $row->status,
            $productsStr,
            $row->total,
        ];
    }

    public function headings(): array
    {
        return [
            'Identificador',
            'Estado',
            'Productos',
            'Total',
        ];
    }
}
