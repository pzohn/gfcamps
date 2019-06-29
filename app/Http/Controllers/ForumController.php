<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postlist;
use App\Models\Postitem;

class ForumController extends Controller
{
    public function savePost(Request $req) {
        $params_psotlist = [
            "valid" => $req->get('valid'),
            "hasVisited" => $req->get('info_name'),
            "title" => $req->get('title'),
            "username" => $req->get('username')
        ];
        $postlist = Postlist::listInsert($params_psotlist);

        $params_psotitem = [
            "valid" => $req->get('itemvalid'),
            "type" => $req->get('type'),
            "color" => $req->get('color'),
            "size" => $req->get('size'),
            "weight" => $req->get('weight'),
            "underline" => $req->get('underline'),
            "imageurl_ids" => $req->get('imageurl_ids'),
            "videourl_ids" => $req->get('videourl_ids'),
            "imgTextFlag" => $req->get('imgTextFlag'),
            "videoTextFlag" => $req->get('videoTextFlag'),
            "videoImgFlag" => $req->get('imageurl_ids'),
            "data" => $req->get('data'),
            "parent_id" => $postlist->id
        ];
        $postitem = Postitem::listInsert($params_psotitem);
    }
}