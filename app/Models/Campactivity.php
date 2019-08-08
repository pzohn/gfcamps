<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Campactivity extends Model {

    public static function GetCampactivities() {

        $campactivities = Campactivity::paginate(10,['*'],'page',3);
        //$campactivities = Campactivity::get();
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
        $campactivities = Campactivity::where("type_id", $typeid)->get();
        if ($campactivities) {
            return $campactivities;
        }
    }

    public static function GetCampactivitiesForWx($typeid) {
        $campactivities = Campactivity::where("type_id", $typeid)->where('wx_id','>',0)->get();
        if ($campactivities) {
            return $campactivities;
        }
    }

    public static function GetCampactivityByCamp($camp_id) {
        $campactivities = Campactivity::where("camp_id", $camp_id)->get();
        if ($campactivities) {
            return $campactivities;
        }
    }

    public static function GetCampactivityByCounty($county_id) {
        $campactivities = Campactivity::where("country_id", $county_id)->get();
        if ($campactivities) {
            return $campactivities;
        }
    }

    public static function GetCampactivityByWxId($wx_id) {
        $campactivity = Campactivity::where("wx_id", $wx_id)->first();
        if ($campactivity) {
            return $campactivity;
        }
    }

    public static function GetCampactivitiesByWxName($name) {
        $campactivities = Campactivity::where('name','like', '%'.$name.'%')->where('wx_id','>',0)->get();
        if ($campactivities) {
            return $campactivities;
        }
    }
}