<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Camp extends Model {
        
    public $timestamps = false;

    public static function GetCamps() {
        $camps = Camp::get();
        if ($camps) {
            return $camps;
        }
    }

    public static function GetCampById($id) {
        $camp = Camp::where("id", $id)->first();
        if ($camp) {
            return $camp;
        }
    }
}