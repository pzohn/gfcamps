<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Carousel extends Model {
        
    public $timestamps = false;

    public static function GetCarousels($typeid) {
        $carousels = \DB::select('SELECT * FROM carousels WHERE type=? ORDER BY RAND() LIMIT 3',[$typeid]);
        if($carousels){
            return $carousels;
        }
    }

    public static function GetCarousel($typeid) {
        $carousels = \DB::select('SELECT * FROM carousels WHERE type=? ORDER BY RAND() LIMIT 1',[$typeid]);
        if($carousels){
            return $carousels;
        }
    }
}