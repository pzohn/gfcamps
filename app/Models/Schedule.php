<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Schedule extends Model {
        
    public $timestamps = false;

    public static function GetSchedule($id) {
        $schedule = Schedule::where("id", $id)->first();
        return $schedule;
    }
}