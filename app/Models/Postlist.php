<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Postlist extends Model {
        
    public static function listInsert($params) {

        $postlist = new self;
        $postlist->valid = array_get($params,"valid");
        $postlist->hasVisited = array_get($params,"hasVisited");
        $postlist->title = array_get($params,"title");
        $postlist->username = array_get($params,"username");
        $postlist->nickname = array_get($params,"nickname");
        $postlist->save();
        return $postlist;
    }

    public static function listGet($id) {
        $postlist = Postlist::where("id", $id)->first();
        if ($postlist) {
            return $postlist;
        }
    }

    public static function listsGetByPhone($phone) {
        $postlists = Postlist::where("username", $phone)->get();;
        if ($postlists) {
            return $postlists;
        }
    }


}