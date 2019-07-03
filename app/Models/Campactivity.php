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

    public static function GetCampactivitiesForWx($typeid) {
        $campactivity = Campactivity::where("type_id", $typeid)->where('wx_id','>',0)->get();
        if ($campactivity) {
            return $campactivity;
        }
    }

    public static function GetCampactivityByCamp($camp_id) {
        $campactivity = Campactivity::where("camp_id", $camp_id)->get();
        if ($campactivity) {
            return $campactivity;
        }
    }

    public static function GetCampactivityByCounty($county_id) {
        $campactivity = Campactivity::where("country_id", $county_id)->get();
        if ($campactivity) {
            return $campactivity;
        }
    }
}