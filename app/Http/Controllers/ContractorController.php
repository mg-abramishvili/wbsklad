<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contractor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContractorController extends Controller
{
    public function index(Request $request)
    {
        $user = User::where('uid', $request->user)->first();

        return Contractor::where('user_id', $user->id)->get();
    }

    public function contractor($uid)
    {
        return Contractor::where('uid', $uid)->first();
    }

    public function store(Request $request)
    {
        $user = User::where('uid', $request->user)->first();

        $contractor = new Contractor();

        $contractor->user_id = $user->id;
        
        $contractor->name = $request->name;
        $contractor->uid = Str::random(24);
        $contractor->tel = $request->tel;
        $contractor->email = $request->email;
        $contractor->kont_litso = $request->kont_litso;
        $contractor->yur_address = $request->yur_address;
        $contractor->pocht_address = $request->pocht_address;
        $contractor->fakt_address = $request->fakt_address;
        $contractor->inn = $request->inn;
        $contractor->kpp = $request->kpp;
        $contractor->ogrn = $request->ogrn;
        $contractor->ras_schet = $request->ras_schet;
        $contractor->korr_schet = $request->korr_schet;
        $contractor->bank = $request->bank;
        $contractor->bik = $request->bik;

        $contractor->save();
    }

    public function update($uid, Request $request)
    {
        $contractor = Contractor::where('uid', $uid)->first();
        
        $contractor->name = $request->name;
        $contractor->tel = $request->tel;
        $contractor->email = $request->email;
        $contractor->kont_litso = $request->kont_litso;
        $contractor->yur_address = $request->yur_address;
        $contractor->pocht_address = $request->pocht_address;
        $contractor->fakt_address = $request->fakt_address;
        $contractor->inn = $request->inn;
        $contractor->kpp = $request->kpp;
        $contractor->ogrn = $request->ogrn;
        $contractor->ras_schet = $request->ras_schet;
        $contractor->korr_schet = $request->korr_schet;
        $contractor->bank = $request->bank;
        $contractor->bik = $request->bik;

        $contractor->save();
    }
}
