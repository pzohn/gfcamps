<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Bigtype extends Model {
        
    public $timestamps = false;

    public static function GetContent($id) {
        $bigtype = Bigtype::where("id", $id)->first();
        return $bigtype->content;
    }
}