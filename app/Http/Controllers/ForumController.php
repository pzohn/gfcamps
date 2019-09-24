<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postlist;
use App\Models\Postitem;
use App\Models\Forumimage;
use App\Models\Forumitem;

class ForumController extends Controller
{
    public function savePostList(Request $req) {
        $params_psotlist = [
            "valid" => $req->get('valid'),
            "hasVisited" => $req->get('hasVisited'),
            "title" => $req->get('title'),
            "username" => $req->get('username'),
            "nickname" => $req->get('nickname')
        ];
        $postlist = Postlist::listInsert($params_psotlist);
        if ($postlist){
            return $postlist->id;
        }
        return 0;
    }

    public function savePostListItem(Request $req) {
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
            "videoImgFlag" => $req->get('videoImgFlag'),
            "data" => $req->get('data'),
            "parent_id" => $req->get('parent_id')
        ];
        $postitem = Postitem::itemInsert($params_psotitem);
        if ($postitem){
            return $postitem;
        }
        return 0;
    }

    public function getPostList(Request $req) {
        $id = $req->get('id');
        $postlist = Postlist::listGet($id);
        $postitems = Postitem::itemsGet($id);

        $postitemsTmp = [];
        foreach ($postitems as $k => $v) {
            $imageurl = "";
            $videourl = "";
            if ($v->imageurl_ids){
                $imageurl = Forumimage::getImageUrl($v->imageurl_ids);
            }
            $postitemsTmp[] = [
                "valid" => $v->valid,
                "type" => $v->type,
                "color" => $v->color,
                "size" => $v->size,
                "weight" => $v->weight,
                "underline" => $v->underline,
                "imageurl" => $imageurl,
                "videourl" => $videourl,
                "imgTextFlag" => $v->imgTextFlag,
                "videoTextFlag" => $v->videoTextFlag,
                "videoImgFlag" => $v->imageurl_ids,
                "data" => $v->data
            ];
        }
        $paraPost = [
            "id" => $postlist->id,
            "valid" => $postlist->valid,
            "hasVisited" => $postlist->hasVisited,
            "title" => $postlist->title,
            "username" => $postlist->username,
            "nickname" => $postlist->nickname,
            "date" => $postlist->created_at->format('Y-m-d'),
            "items" => $postitemsTmp
        ];
        return $paraPost;
    }

    public function getPostLists() {
        $postlists = Postlist::listsGet();
        $postlistsTmp = [];
        foreach ($postlists as $k => $v) {
            $itemImage = Postitem::itemImgGet($v->id);
            $imgUrl = "";
            if ($itemImage){
                $imgUrl = Forumimage::getImageUrl($itemImage->imageurl_ids);
            }
            $postlistsTmp[] = [
                "id" => $v->id,
                "title" => $v->title,
                "nickname" => $v->nickname,
                "date" => $v->created_at->format('Y-m-d'),
                "pic" => $imgUrl
            ];
        }
        return $postlistsTmp;
    }

    public function getPostListsByPhone(Request $req) {
        $phone = $req->get('phone');
        $postlists = Postlist::listsGetByPhone($phone);
        $postlistsTmp = [];
        foreach ($postlists as $k => $v) {
            $itemImage = Postitem::itemImgGet($v->id);
            $imgUrl = "";
            if ($itemImage){
                $imgUrl = Forumimage::getImageUrl($itemImage->imageurl_ids);
            }
            $postlistsTmp[] = [
                "id" => $v->id,
                "title" => $v->title,
                "nickname" => $v->nickname,
                "date" => $v->created_at->format('Y-m-d'),
                "pic" => $imgUrl
            ];
        }
        return $postlistsTmp;
    }

    public function newForum(Request $req) {
        $param= [
            "userid" => $req->get('openid'),
            "content" => $req->get('content'),
            "article_id" => $req->get('article_id')
        ];
        Forumitem::insertItem($param);
    }
}
