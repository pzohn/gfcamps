<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\GuzzleHttp;
use App\Models\City;


class PayController extends Controller
{
    public function getCity(Request $req) {
        \Log::info("1111111111111111111",[]);
        $id = $req->get('id');
        $city = City::getCity($id);
        return $city->name;
    }
}
