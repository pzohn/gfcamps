<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;

class CollectionController extends Controller
{
    public function insertOneCollectionItem(Request $req) {
        $params_psotitem = [
            "openid" => $req->get('openid'),
            "articalid" => $req->get('articalid')
        ];
        $postitem = Collection::writeOneItem($params_psotitem);
        if ($postitem){
            return $postitem;
        }
        return 0;
    }
}
