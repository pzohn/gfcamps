<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Forumitem extends Model {

    public static function insertItem($param) {
        $forumitem = new self;
        $forumitem->userid = array_get($param,"userid");
        $forumitem->content = array_get($param,"content");
        $forumitem->article_id = array_get($param,"article_id");
        $forumitem->save();
        return $forumitem;
    }

    public static function getItemsByUseId($userid) {
        $forumitems = Forumitem::where("userid", $userid)->orderBy('updated_at', 'desc')->get();
        return $forumitems;
    }
}