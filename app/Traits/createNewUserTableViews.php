<?php

namespace App\Traits;

use App\Models\TableView;
use App\Traits\updateProductCostPrice;

trait createNewUserTableViews
{    
    public function createNewUserTableViews($userUID) {
        $productsTable = array(
            [
                "id" => 1,
                "field" => "nm_id",
                "headerName" => "Код WB",
                "width" => 200,
                "order" => 99,
                "isActive" => true
            ],
            [
                "id" => 2,
                "field" => "subject",
                "headerName" => "Предмет",
                "width" => 200,
                "order" => 99,
                "isActive" => true
            ],
            [
                "id" => 3,
                "field" => "supplier_article", 
                "headerName" => "Артикул",
                "width" => 200,
                "order" => 99,
                "isActive" => true
            ],
            [
                "id" => 4,
                "field" => "category",
                "headerName" => "Категория",
                "width" => 200,
                "order" => 99,
                "isActive" => true
            ],
            [
                "id" => 5,
                "field" => "brand",
                "headerName" => "Бренд",
                "width" => 200,
                "order" => 99,
                "isActive" => true
            ],
            [
                "id" => 6,
                "field" => "price",
                "headerName" => "Цена",
                "width" => 200,
                "order" => 99,
                "isActive" => true
            ],
            [
                "id" => 7,
                "field" => "cost_price",
                "headerName" => "Себестоимость",
                "width" => 200,
                "order" => 99,
                "isActive" => true
            ],
            [
                "id" => 8,
                "field" => "tech_size",
                "headerName" => "Размер",
                "width" => 200,
                "order" => 99,
                "isActive" => true
            ],
            [
                "id" => 9,
                "field" => "barcode",
                "headerName" => "Штрихкод",
                "width" => 200,
                "order" => 99,
                "isActive" => true
            ],
            [
                "id" => 10,
                "field" => "quantity",
                "headerName" => "Количество",
                "width" => 200,
                "order" => 99,
                "isActive" => true
            ]
        );
        
        $newTableViews = new TableView();
        $newTableViews->user_uid = $userUID;
        $newTableViews->table_name = 'products';
        $newTableViews->columns = $productsTable;
        $newTableViews->save();
    }
}