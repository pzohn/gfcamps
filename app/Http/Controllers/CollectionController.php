<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;

class CollectionController extends Controller
{
    public function insertOneCollectionItem(Request $req) {
        $params_psotitem = [
            "openid" => $req->get('openid'),
            "articalid" => $req->get('articalid'),
            "title" => $req->get('title'),
            "nickname" => $req->get('nickname'),
            "imgurls" => $req->get('imgurls'),
            "donetime" => $req->get('donetime'),
        ];
        $postitem = Collection::writeOneItem($params_psotitem);
        if ($postitem){
            return $postitem;
        }
        return 0;
    }

    public function deleteOneCollectionItem(Request $req) {
        $params_psotitem = [
            "openid" => $req->get('openid'),
            "articalid" => $req->get('articalid')
        ];
        $postitem = Collection::deleteOneItem($params_psotitem);
        if ($postitem){
            return $postitem;
        }
        return 0;
    }
    
    public function getUserCollections(Request $req) {
        $openid = $req->get('openid');
        $postitem = Collection::getUserItems($openid);
        if ($postitem){
            return $postitem;
        }
        return 0;
    }

    public function getUserOneCollection(Request $req) {
        $params_psotitem = [
            "openid" => $req->get('openid'),
            "articalid" => $req->get('articalid')
        ];
        $postitem = Collection::GetOneItem($params_psotitem);
        if ($postitem){
            return $postitem;
        }
        return 0;
    }
}
