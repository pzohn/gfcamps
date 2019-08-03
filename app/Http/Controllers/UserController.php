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
        $memeber = Member::memberInsertPhone($phone);
        if($memeber)
            return $memeber->id;
        return 0;
    }

    public function collect(Request $req) {
        $collect_flag = $req->get('collect_flag');
        $phone = $req->get('phone');
        $detail_id = $req->get('detail_id');
        $iscollect = $this->iscollect($req);
        if ($iscollect == $collect_flag)
            return $iscollect;
        $collect_ids = Member::memberSelect($phone)->collect_ids;
        $collect_idsTmp = "";
        if ($collect_flag){
            if ($collect_ids == ""){
                $collect_idsTmp = strval($detail_id);
            }else{
                $collect_idsTmp = $collect_ids . "@" . strval($detail_id);
            }
        }else{
            if (strpos($collect_ids, '@') !== false){
                $arry = preg_split("/@/",$collect_ids);
                $arryTmp = [];
                foreach ($arry as $k => $v) {
                    $id = intval($v);
                    if ($id != $detail_id){
                        $arryTmp[] = $v;
                    }
                    $collect_idsTmp = implode("@",$arryTmp);
                }
            }else{
                $collect_idsTmp = "";
            }
        }
        Member::CollectUpdate($phone,$collect_idsTmp);
        return $this->iscollect($req);
    }

    public function iscollect(Request $req) {
        $phone = $req->get('phone');
        $detail_id = $req->get('detail_id');
        $member = Member::memberSelect($phone);
        if (!$member)
            return 0;
        $collect_ids = $member->collect_ids;
        if ($collect_ids == "")
            return 0;
        if (strpos($collect_ids, '@') !== false){
            $arry = preg_split("/@/",$collect_ids);
            $flag = false;
            foreach ($arry as $k => $v) {
                $id = intval($v);
                if ($id == $detail_id){
                    $flag = true;
                }
            }
            if ($flag){
                return 1;
            }else{
                return 0;
            }
        }else{
            $id = intval($collect_ids);
            if ($id == $detail_id){
                return 1;
            }else{
                return 0;
            }
        }
    }

    public function getCollect(Request $req) {
        $phone = $req->get('phone');
        $member = Member::memberSelect($phone);
        if (!$member)
            return 0;
        $collect_ids = $member->collect_ids;
        if ($collect_ids == "")
            return 0;
        return $collect_ids;
    }

    public function memberUpdate(Request $req) {
        $params = [
            'phone' => $req->get('phone'),
            'name' => $req->get('name'),
            'email' => $req->get('email'),
            'sex' => $req->get('sex'),
            'age' => $req->get('age')
            ];
        $member = Member::memberUpdatePhone($params);
        if ($member){
            return $member;
        }
    }

    public function memberSelect(Request $req) {
        $member = Member::memberSelect($req->get('phone'));
        if ($member){
            return $member;
        }
    }
}