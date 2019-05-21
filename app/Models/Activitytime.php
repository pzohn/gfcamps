<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Activitytime extends Model {
        
    public $timestamps = false;

    public static function GetActivityTime($id) {
        $activitytime = Activitytime::where("id", $id)->first();
        return $activitytime->desc;
    }
}