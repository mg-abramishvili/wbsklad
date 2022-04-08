<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserCatalogTableColumn;
use App\Http\Resources\UserCatalogTableColumnResource;
use Illuminate\Http\Request;

class UserCatalogTableColumnController extends Controller
{
    public function index(Request $request)
    {
        $user = User::where('uid', $request->user)->first();

        if(!$user) {
            return;
        }

        $columns = UserCatalogTableColumn::where('user_id', $user->id)->with('catalogTableColumn')->orderBy('order', 'asc')->get();

        return UserCatalogTableColumnResource::collection($columns);
    }

    public function update(Request $request)
    {
        $user = User::where('uid', $request->user)->first();

        if(!$user) {
            return;
        }

        foreach($request->columns_params as $columnParam)
        {
            $column = UserCatalogTableColumn::find($columnParam['id']);
            $column->width = $columnParam['width'];
            $column->order = $columnParam['order'];
            $column->isActive = $columnParam['isActive'];
            $column->save();
        }
    }
}
