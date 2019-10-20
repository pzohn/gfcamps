<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Collection extends Model {
    public static function writeOneItem($params) {

        $postitem = new self;
        $postitem->openid = array_get($params,"openid");
        $postitem->articalid = array_get($params,"articalid");
        $postitem->save();
        return $postitem;
    }

    public static function deleteOneItem($params) {

        $postitem = new self;
        $postitem->openid = array_get($params,"openid");
        $postitem->articalid = array_get($params,"articalid");
        $openid = $postitem->openid;
        $articalid = $postitem->articalid;
        $item = Collection::where("openid", $openid)->where("articalid", $articalid)->get();
        $item->delete();
        return $postitem;

        
    }
}