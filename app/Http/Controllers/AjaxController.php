<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Province;
use App\Models\RajaOngkir;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function cities(Request $request, $province)
    {
        $r = City::where('province_id', $province);

        $r->when($request->get('q'), function ($q) use ($request) {
            return $q->where('name', 'like', '%'.$request->get('q').'%');
        });

        return response()->json(['results' => $r->pluck('name', 'id')]);
    }

    public function provinces(Request $request)
    {
        $r = Province::query();

        $r->when($request->get('q'), function ($q) use ($request) {
            return $q->where('name', 'like', '%'.$request->get('q').'%');
        });

        return response()->json(['results' => $r->pluck('name', 'id')]);
    }

    public function shippingRate(Request $request, RajaOngkir $ongkir)
    {
        $this->validate($request, [
            'origin' => 'required|numeric',
            'destination' => 'required|numeric',
            'weight' => 'required|numeric|min:1',
            'courier' => 'required|string|in:JNE,TIKI,POS'
        ]);

        $results = $ongkir->costs($request->origin, $request->destination, $request->weight, strtolower($request->courier));

        return response()->json(['status' => $ongkir->getStatusCode() === 200 ? 'OK' : 'ERROR', 'results' => $results], $ongkir->getStatusCode());
    }
}
