<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  SendAddress extends Model {
        
    public $timestamps = false;

    public static function GetAddress($id) {
        $address = Address::where("trade_id", $id)->first();
        if ($address) {
            return $address;
        }
    }

    public static function addressInsert($params) {
        $address = new self;
        $address->name = array_get($params,"name");
        $address->phone = array_get($params,"phone");
        $address->province = array_get($params,"province");
        $address->city = array_get($params,"city");
        $address->area = array_get($params,"area");
        $address->trade_id = array_get($params,"trade_id");
        $address->detail = array_get($params,"detail");
        $address->save();
        return $address;
    }
}