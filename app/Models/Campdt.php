<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Campdt extends Model {
        
    public $timestamps = false;

    public static function GetActivityTime($id) {
        $campdt = Campdt::where("id", $id)->first();
        return $campdt->id;
    }
}