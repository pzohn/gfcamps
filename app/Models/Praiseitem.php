<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Praiseitem extends Model {
        
    public static function listInsert($params) {

        $praiseitem = new self;
        $praiseitem->userid = array_get($params,"userid");
        $praiseitem->parent_id = array_get($params,"parent_id");
        $praiseitem->save();
        return $praiseitem;
    }
}