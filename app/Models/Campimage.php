<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Campimage extends Model {
    
    public static function GetImage($id) {
        $image = Campimage::where("id", $id)->first();
        if ($image) {
            return $image;
        }
    }

    public static function GetImageUrl($id) {
        $image = Campimage::where("id", $id)->first();
        if ($image) {
            if($image->file){
                if($image->url){
                    return $image->file . "/" . $image->url;
                }
            }
        }
        return null;
    }
}