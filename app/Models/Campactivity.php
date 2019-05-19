<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Campactivity extends Model {

    public static function GetCampactivities() {
        $campactivities = Campactivity::get();
        if ($campactivities) {
            return $campactivities;
        }
    }

    public static function GetCampactivityById($id) {
        $campactivity = Campactivity::where("id", $id)->first();
        if ($campactivity) {
            return $campactivity;
        }
    }

    public static function GetCampactivitiesByTypeId($typeid) {
        $campactivity = Campactivity::where("type_id", $typeid)->get();
        if ($campactivity) {
            return $campactivity;
        }
    }
}