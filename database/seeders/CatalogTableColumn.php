<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CatalogTableColumn extends Seeder
{
    public function run()
    {
        DB::table('catalog_table_columns')->insert([
            [
                'id' => 1,
                'field' => 'nm_id',
                'headerName' => 'Код WB',
                'sortable' => true,
                'resizable' => true,
            ],
            [
                'id' => 2,
                'field' => 'subject',
                'headerName' => 'Предмет',
                'sortable' => true,
                'resizable' => true,
            ],
            [
                'id' => 3,
                'field' => 'supplier_article',
                'headerName' => 'Артикул',
                'sortable' => true,
                'resizable' => true,
            ],
            [
                'id' => 4,
                'field' => 'category',
                'headerName' => 'Категория',
                'sortable' => true,
                'resizable' => true,
            ],
            [
                'id' => 5,
                'field' => 'brand',
                'headerName' => 'Бренд',
                'sortable' => true,
                'resizable' => true,
            ],
            [
                'id' => 6,
                'field' => 'price',
                'headerName' => 'Цена',
                'sortable' => true,
                'resizable' => true,
            ],
            [
                'id' => 7,
                'field' => 'tech_size',
                'headerName' => 'Размер',
                'sortable' => true,
                'resizable' => true,
            ],
            [
                'id' => 8,
                'field' => 'barcode',
                'headerName' => 'Штрихкод',
                'sortable' => true,
                'resizable' => true,
            ],
            [
                'id' => 9,
                'field' => 'quantity',
                'headerName' => 'Количество',
                'sortable' => true,
                'resizable' => true,
            ],
        ]);
    }
}