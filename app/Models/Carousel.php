<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Carousel extends Model {
        
    public $timestamps = false;

    public static function GetCarousels($typeid) {
        $carousels = DB::select('SELECT * FROM carousels WHERE type=$typeid ORDER BY RAND() LIMIT 3');
        if($carousels){
            return $carousels;
        }
    }
}