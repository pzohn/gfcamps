<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Qcloud\Sms\SmsSingleSender;

class UserController extends Controller
{
    public function loginByPhone(Request $req) {
        $appid = 1400184176;
        $appkey = 'c5f98a9fd6a8828dea964516fc98e574';
        $phone = $req->get('phone');
        $templateId = 295943;
        $smsSign = '';
        $code = $this->createRand(4);
        try {
            $sender = new SmsSingleSender($appid, $appkey);
            $params = [$code];
            $result = $sender->sendWithParam("86", $phone, $templateId, $params, $smsSign, "", "");
            $res = json_decode($result, true);
            $data = $res["result"];
            if ($data == 0){
                return $code;
            }
            return "0000";
        } catch (\Exception $e) {
            var_dump($e);
        }	
    }

    protected function createRand($length) {
        $str='0123456789';
        $len=strlen($str)-1;
        $randstr='';
        for($i=0;$i<$length;$i++){
        $num=mt_rand(0,$len);
        $randstr .= $str[$num];
        }
        return $randstr;
    }

    public function savePhone(Request $req) {
        $phone = $req->get('phone');
        $memeber = Member::memberSelect($phone);
        if($memeber)
            return $memeber->id;
        $memeber = Member::memberSememberInsertPhonelectPhone($phone);
        if($memeber)
            return $memeber->id;
        return 0;
    }
}