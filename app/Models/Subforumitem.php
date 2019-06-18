<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Subforumitem extends Model {
        
    public static function listInsert($params) {

        $subforumitem = new self;
        $subforumitem->userid = array_get($params,"userid");
        $subforumitem->parent_id = array_get($params,"parent_id");
        $subforumitem->content = array_get($params,"content");
        $subforumitem->forumuserid = array_get($params,"forumuserid");
        $subforumitem->save();
        return $subforumitem;
    }
}