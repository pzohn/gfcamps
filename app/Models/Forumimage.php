<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Forumimage extends Model {
    
    public $timestamps = false;
    
    public static function InsertImage($url) {
        $forumimage = new self;
        $forumimage->url = $url;
        $forumimage->save();
        return $forumimage->id;
    }

    public static function getImageUrl($id) {
        $forumimage = Forumimage::where("id", $id)->first();
        if ($forumimage){
            return $forumimage->url;
        }
    }
}