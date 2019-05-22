<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Member;


class MessageController extends Controller
{
    public function saveMessage(Request $req) {
        $phone = $req->get('info_phone');
        if($phone){
            $member = Member::memberSelect($phone);
            if(!$member){
                $params = [
                    "phone" => $phone,
                    "name" => $req->get('info_name'),
                    "email" => $req->get('info_email')
                ];
                Member::memberInsert($params);
            }
            $content = $req->get('info_message');
            if ($content){
                $params = [
                    "phone" => $phone,
                    "content" => $content
                ];
                Message::messageInsert($params);
            }
        }
    }
}
