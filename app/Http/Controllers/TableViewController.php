<?php

namespace App\Http\Controllers;

use App\Models\TableView;
use Illuminate\Http\Request;

class TableViewController extends Controller
{
    public function index(Request $request)
    {
        return TableView::where('user_uid', $request->user)->get();
    }
}
