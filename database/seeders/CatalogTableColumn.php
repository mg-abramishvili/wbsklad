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
            ],
            [
                'id' => 2,
                'field' => 'subject',
                'headerName' => 'Предмет',
            ],
            [
                'id' => 3,
                'field' => 'supplier_article',
                'headerName' => 'Артикул',
            ],
            [
                'id' => 4,
                'field' => 'category',
                'headerName' => 'Категория',
            ],
            [
                'id' => 5,
                'field' => 'brand',
                'headerName' => 'Бренд',
            ],
            [
                'id' => 6,
                'field' => 'price',
                'headerName' => 'Цена',
            ],
            [
                'id' => 7,
                'field' => 'cost_price',
                'headerName' => 'Себестоимость',
            ],
            [
                'id' => 8,
                'field' => 'tech_size',
                'headerName' => 'Размер',
            ],
            [
                'id' => 9,
                'field' => 'barcode',
                'headerName' => 'Штрихкод',
            ],
            [
                'id' => 10,
                'field' => 'quantity',
                'headerName' => 'Количество',
            ],
        ]);
    }
}