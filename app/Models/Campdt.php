<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Campdt extends Model {
        
    protected $table = "campdts";
    public $timestamps = false;

    public static function GetActivityTime($id) {
        $campdt = Campdt::where("id", $id)->first();
        if ($campdt){
            return $campdt->desc;
        }
    }
}