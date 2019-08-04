<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Ninesquare extends Model {
        
    public static function getNine() {
        $ninesquares = \DB::select('SELECT * FROM ninesquares LIMIT 9');
        if($ninesquares){
            return $ninesquares;
        }
    }
}
