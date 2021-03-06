<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Collection extends Model {
    public static function writeOneItem($params) {

        $postitem = new self;
        $postitem->openid = array_get($params,"openid");
        $postitem->articalid = array_get($params,"articalid");
        $postitem->title = array_get($params,"title");
        $postitem->nickname = array_get($params,"nickname");
        $postitem->imgurls = array_get($params,"imgurls");
        $postitem->donetime = array_get($params,"donetime");
        $postitem->save();
        return $postitem;
    }

    public static function deleteOneItem($params) {

        $postitem = new self;
        $postitem->openid = array_get($params,"openid");
        $postitem->articalid = array_get($params,"articalid");
        $openid = $postitem->openid;
        $articalid = $postitem->articalid;
        Collection::where("openid", $openid)->where("articalid", $articalid)->delete();
    }

    public static function getUserItems($openid) {
        $items = Collection::where("openid", $openid)->get();
        if ($items) {
            return $items;
        }
    }

    public static function GetOneItem($params) {

        $postitem = new self;
        $postitem->openid = array_get($params,"openid");
        $postitem->articalid = array_get($params,"articalid");
        $openid = $postitem->openid;
        $articalid = $postitem->articalid;
        $item = Collection::where("openid", $openid)->where("articalid", $articalid)->get();
        if ($item) {
            return $item;
        }
    }
}