<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\User;
use App\Http\Resources\ServiceResource;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $user = User::where('uid', $request->user)->first();

        return ServiceResource::collection(Service::where('user_id', $user->id)->orderBy('date', 'desc')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'user' => 'required',
            'date' => 'required',
            'contractor_id' => 'required',
            'nomenclatures' => 'required',
        ]);

        $user = User::where('uid', $request->user)->first();

        $service = new StockBalance();

        $service->user_id = $user->id;
        
        $service->uid = Str::random(24);
        $service->contractor_id = $request->contractor_id;
        $service->date = $request->date;

        $service->save();
        
        foreach($request->nomenclatures as $nomenclature) {
            $serviceItem = new ServiceItem();
            $serviceItem->nomenclature_id = $nomenclature['id'];
            $serviceItem->service_id = $service->id;
            $serviceItem->price = $nomenclature['total'];
            $serviceItem->date = $request->date;
            $serviceItem->save();
            
            $this->updateMiddlePriceAndQuantity($nomenclature['id']);
        }
    }
}
