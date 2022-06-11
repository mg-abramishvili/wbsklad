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

    public function update(Request $request)
    {
        $tableView = TableView::query()
            ->where('user_uid', $request->user)
            ->where('table_name', $request->table_name)
            ->first();
        
        $tableView->columns = $request->columns;
        
        $tableView->save();
    }
}
