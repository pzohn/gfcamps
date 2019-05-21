<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Littletype extends Model {
        
    public $timestamps = false;

    public static function GetBigId($id) {
        $littletype = Littletype::where("id", $id)->first();
        return $littletype->parent_id;
    }
}