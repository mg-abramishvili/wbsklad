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

    public function update(Request $request)
    {
        $user = User::where('uid', $request->uid)->first();

        if(!$user) {
            return;
        }

        $user->catalogTableColumns()->sync($request->columns);
    }
}
