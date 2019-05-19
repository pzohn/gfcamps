<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Show extends Model {
        
    public $timestamps = false;

    public static function GetShowsByType($typeid) {
        $shows = Show::where("type_id", $typeid)->get();
        return $shows;
    }
}