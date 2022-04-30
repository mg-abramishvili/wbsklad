<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceItem;
use App\Models\User;
use App\Http\Resources\ServiceResource;
use App\Traits\updateMiddlePriceAndQuantity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    use updateMiddlePriceAndQuantity;

    public function index(Request $request)
    {
        $user = User::where('uid', $request->user)->first();

        return ServiceResource::collection(Service::where('user_id', $user->id)->orderBy('date', 'desc')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'user' => 'required',
            'name' => 'required',
            'price' => 'required',
            'date' => 'required',
            'contractor_id' => 'required',
            'nomenclatures' => 'required',
        ]);

        $user = User::where('uid', $request->user)->first();

        $service = new Service();

        $service->user_id = $user->id;
        
        $service->uid = Str::random(24);
        $service->name = $request->name;
        $service->price = $request->price;
        $service->contractor_id = $request->contractor_id;
        $service->date = $request->date;

        $service->save();
        
        foreach($request->nomenclatures as $nomenclature) {
            $serviceItem = new ServiceItem();
            $serviceItem->nomenclature_id = $nomenclature['id'];
            $serviceItem->service_id = $service->id;
            $serviceItem->price = $nomenclature['price'];
            $serviceItem->date = $request->date;
            $serviceItem->save();
            
            $this->updateMiddlePriceAndQuantity($nomenclature['id']);
        }
    }
}
