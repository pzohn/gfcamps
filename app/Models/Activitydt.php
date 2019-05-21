<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Activitydt extends Model {
        
    public $timestamps = false;

    public static function GetActivityTime($id) {
        $activitydt = Activitydt::where("id", $id)->first();
        return $activitydt->desc;
    }
}