<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zizhiimage extends Model {

    public static function GetImageUrl($id) {
        $image = Zizhiimage::where("id", $id)->first();
        if ($image) {
            if($image->url){
                return "zizhi/" . $image->url;
            }
        }
        return null;
    }
}