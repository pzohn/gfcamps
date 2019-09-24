<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Forumitem extends Model {

    public static function insertItem($param) {
        $forumitem = new self;
        $forumitem->userid = array_get($params,"userid");
        $forumitem->content = array_get($params,"content");
        $forumitem->article_id = array_get($params,"article_id");
        $forumitem->save();
        return $forumitem;
    }
}