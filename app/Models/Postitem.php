<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Postitem extends Model {
        
    public static function itemInsert($params) {

        $postitem = new self;
        $postitem->valid = array_get($params,"valid");
        $postitem->type = array_get($params,"type");
        $postitem->color = array_get($params,"color");
        $postitem->size = array_get($params,"size");
        $postitem->weight = array_get($params,"weight");
        $postitem->underline = array_get($params,"underline");
        $postitem->imgTextFlag = array_get($params,"imgTextFlag");
        $postitem->videoTextFlag = array_get($params,"videoTextFlag");
        $postitem->imageurl_ids = array_get($params,"imageurl_ids");
        $postitem->videourl_ids = array_get($params,"videourl_ids");
        $postitem->videoImgFlag = array_get($params,"videoImgFlag");
        $postitem->data = array_get($params,"data");
        $postitem->parent_id = array_get($params,"parent_id");
        $postitem->save();
        return $postitem;
    }

    public static function itemsGet($id) {
        $postitems = Postitem::where("parent_id", $id)->get();
        if ($postitems) {
            return $postitems;
        }
    }

    public static function itemImgGet($id) {
        $postitem = Postitem::where("parent_id", $id)->where("type", 3)->first();
        if ($postitem) {
            return $postitem;
        }
    }
}