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
}