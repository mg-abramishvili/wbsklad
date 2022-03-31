<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CatalogTableColumn;
use Illuminate\Http\Request;

class CatalogTableColumnController extends Controller
{
    public function index()
    {
        return CatalogTableColumn::all();
    }
}
