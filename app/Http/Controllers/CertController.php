<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cert;
use App\Models\Campactivity;
use App\Models\Wxinfo;
use App\Models\Image;

class CertController extends Controller
{
    public function certInsert(Request $req) {
       $cert = Cert::certSelect( $req->get('id'));
       if ($cert){
            $count = $cert->count + $req->get('count');
            Cert::certupdate($cert->id,$count);
            return $cert;
       }
       $params = [
        'username' => $req->get('username'),
        'shopping_id' => $req->get('id'),
        'count' => $req->get('count')
        ];
        return Cert::certInsert($params);
    }

    public function certsSelect(Request $req) {
        $username = $req->get('username');
        $certs = Cert::certsSelect($username);
        $certsTmp = [];
        foreach ($certs as $k => $v) {
            $shopping = Campactivity::GetCampactivityById($v->shopping_id);
            $wx_info = Wxinfo::GetWxinfoById($shopping->wx_id);
            $certsTmp[] = [
            "shoppingid" => $shopping->id,
            "name" => $shopping->name,
            "title_pic" => Image::GetImageUrl($wx_info->title_id),
            "price" => $shopping->charge,
            "count" => $v->count,
            "id" => $v->id
            ];
        }
        return  $certsTmp;
     }

     public function certdelete(Request $req) {
        $id = $req->get('id');
        Cert::certdelete($id);
        return 1;
     }

     public function certupdate(Request $req) {
        $id = $req->get('id');
        $count = $req->get('count');
        Cert::certupdate($id,$count);
     }
}