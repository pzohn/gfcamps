<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Special extends Model {
        
    public $timestamps = false;

    public static function GetSpecial($id) {
        $special = Special::where("id", $id)->first();
        if ($special)
        return $special;
    }
}