<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\GuzzleHttp;
use App\Models\City;


class PayController extends Controller
{
    public function getCity(Request $req) {
        $id = $req->get('id');
        $city = City::getCity($id);
        return $city->name;
    }
}
