<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\GuzzleHttp;
use App\Models\City;
use App\Models\Trade;
use App\Models\Campactivity;
use App\Models\Wxinfo;
use App\Models\Image;
use App\Models\Childtrade;
use App\Models\SendAddress;
use App\Models\Address;


class PayController extends Controller
{
    public function getCity(Request $req) {
        $id = $req->get('id');
        $city = City::getCity($id);
        return $city->name;
    }

    public function onPay(Request $req) {

        $urlLogin = "https://api.weixin.qq.com/sns/jscode2session";
        $paramsLogin = [
        	'appid' => "wx25428722a46f46c4",
            'secret' => "13accb5ad3afe802ed10360210b52633",
            'js_code' => $req->get('js_code'),
            'grant_type' => "authorization_code",
        ];
        try {
            $resultLogin = GuzzleHttp::guzzleGet($urlLogin, $paramsLogin);
            if (isset($resultLogin['errcode'])) {
                return [
                    "errcode" => $resultLogin['errcode'],
                    "errmsg" => "无效登录信息",
                ];
            }
            $openid = $resultLogin['openid'];
            $session_key = $resultLogin['session_key'];

            if ($openid && $session_key) {
                $campactivity = Campactivity::GetCampactivityById($req->get('detail_id'));
                $urlPay = "https://api.mch.weixin.qq.com/pay/unifiedorder";
                $params = [
                    'appid' => $paramsLogin["appid"],
                    'body' => $campactivity->name,
                    'mch_id' => "1547227511",
                    'nonce_str' => $this->createRand(32),
                    'notify_url' => "https://www.gfcamps.cn/onPayBack",
                    'openid' => $openid,
                    'out_trade_no'=> $this->createTradeNo(),
                    'spbill_create_ip' => $req->getClientIp(),
                    'total_fee' => $campactivity->charge * 100 * $req->get('num'),
                    'trade_type' => "JSAPI",
                    ];

                    ksort($params);

                    $stringA = "";
                    foreach ($params as $k => $v) {
                        $stringA = $stringA . "&" . $k . "=" . $v;
                    }
                    $stringA = ltrim($stringA, "&");

                    $appid = $params["appid"];
                    $mch_id = $params["mch_id"];
                    $nonce_str = $params["nonce_str"];
                    $body = $params["body"];
                    $out_trade_no = $params["out_trade_no"];
                    $total_fee = $params["total_fee"];
                    $spbill_create_ip = $req->getClientIp();
                    $notify_url = $params["notify_url"];
                    $trade_type = $params["trade_type"];
                    $sign = $this->createSign($stringA);


                    $data = "<xml>
                    <appid>$appid</appid>
                    <body>$body</body>
                    <mch_id>$mch_id</mch_id>
                    <nonce_str>$nonce_str</nonce_str>
                    <notify_url>$notify_url</notify_url>
                    <openid>$openid</openid>
                    <out_trade_no>$out_trade_no</out_trade_no>
                    <spbill_create_ip>$spbill_create_ip</spbill_create_ip>
                    <total_fee>$total_fee</total_fee>
                    <trade_type>$trade_type</trade_type>
                    <sign>$sign</sign>
                 </xml>";
                 \Log::info("-----------pay", [$data]);
                 $trade = [
                    'out_trade_no' => $params["out_trade_no"],
                    'body' => $params["body"],
                    'detail_id' => $req->get('detail_id'),
                    'total_fee' => $params["total_fee"] * 0.01,
                    'phone' => $req->get('phone')
                 ];
                 $tradeNew = Trade::payInsert($trade);
                 $childtrade = [
                    'shopping_id' => $req->get('detail_id'),
                    'num' => $req->get('num'),
                    'trade_id' => $tradeNew->id
                 ];
                 Childtrade::payInsert($childtrade);
                 $this->insertAddress($req->get('address_id'),$tradeNew->id);
                 $resultPay = GuzzleHttp:: postXml($urlPay, $data);
                 $decode = $this->decodeXml($resultPay);
                 if ($decode["result_code"] == "SUCCESS")
                 {
                    $sian_time = (string)time();
                    $resign = $this->createReSign($decode,$sian_time);
                    return $this->wxBack($decode,$resign,$sian_time);
                 }
                 else if($decode["result_code"] == "FAIL")
                 {
                     return [
                        "errcode" => $decode["err_code"],
                        "errmsg" => $decode["err_code_des"],
                     ];
                 }

            }

        } catch (\Exception $e) {
            // 异常处理
            \Log::info("----------", [$e]);
            return [
                "code" => $e->getCode(),
                "msg"  => $e->getMessage(),
                "data" => [],
            ];
        }
    }

    public function onRePay(Request $req) {

        $urlLogin = "https://api.weixin.qq.com/sns/jscode2session";
        $paramsLogin = [
        	'appid' => "wx25428722a46f46c4",
            'secret' => "13accb5ad3afe802ed10360210b52633",
            'js_code' => $req->get('js_code'),
            'grant_type' => "authorization_code",
        ];
        try {
            $resultLogin = GuzzleHttp::guzzleGet($urlLogin, $paramsLogin);
            if (isset($resultLogin['errcode'])) {
                return [
                    "errcode" => $resultLogin['errcode'],
                    "errmsg" => "无效登录信息",
                ];
            }
            $openid = $resultLogin['openid'];
            $session_key = $resultLogin['session_key'];

            if ($openid && $session_key) {
                $trade = Trade::paySelectById($req->get('trade_id'));
                $urlPay = "https://api.mch.weixin.qq.com/pay/unifiedorder";
                $params = [
                    'appid' => $paramsLogin["appid"],
                    'body' => $trade->body,
                    'mch_id' => "1547227511",
                    'nonce_str' => $this->createRand(32),
                    'notify_url' => "https://www.gfcamps.cn/onPayBack",
                    'openid' => $openid,
                    'out_trade_no'=> $trade->out_trade_no,
                    'spbill_create_ip' => $req->getClientIp(),
                    'total_fee' => $trade->total_fee * 100,
                    'trade_type' => "JSAPI",
                    ];
                    ksort($params);

                    $stringA = "";
                    foreach ($params as $k => $v) {
                        $stringA = $stringA . "&" . $k . "=" . $v;
                    }
                    $stringA = ltrim($stringA, "&");

                    $appid = $params["appid"];
                    $mch_id = $params["mch_id"];
                    $nonce_str = $params["nonce_str"];
                    $body = $params["body"];
                    $out_trade_no = $params["out_trade_no"];
                    $total_fee = $params["total_fee"];
                    $spbill_create_ip = $req->getClientIp();
                    $notify_url = $params["notify_url"];
                    $trade_type = $params["trade_type"];
                    $sign = $this->createSign($stringA);


                    $data = "<xml>
                    <appid>$appid</appid>
                    <body>$body</body>
                    <mch_id>$mch_id</mch_id>
                    <nonce_str>$nonce_str</nonce_str>
                    <notify_url>$notify_url</notify_url>
                    <openid>$openid</openid>
                    <out_trade_no>$out_trade_no</out_trade_no>
                    <spbill_create_ip>$spbill_create_ip</spbill_create_ip>
                    <total_fee>$total_fee</total_fee>
                    <trade_type>$trade_type</trade_type>
                    <sign>$sign</sign>
                 </xml>";
                 \Log::info("-----------repay", [$data]);
                 $resultPay = GuzzleHttp:: postXml($urlPay, $data);
                 $decode = $this->decodeXml($resultPay);
                 if ($decode["result_code"] == "SUCCESS")
                 {
                    $sian_time = (string)time();
                    $resign = $this->createReSign($decode,$sian_time);
                    return $this->wxBack($decode,$resign,$sian_time);
                 }
                 else if($decode["result_code"] == "FAIL")
                 {
                     return [
                        "errcode" => $decode["err_code"],
                        "errmsg" => $decode["err_code_des"],
                     ];
                 }

            }

        } catch (\Exception $e) {
            // 异常处理
            \Log::info("----------", [$e]);
            return [
                "code" => $e->getCode(),
                "msg"  => $e->getMessage(),
                "data" => [],
            ];
        }
    }


    protected function decodeXml($xml) {
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $values;
    }

    protected function createRand($length) {
        $str='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $len=strlen($str)-1;
        $randstr='';
        for($i=0;$i<$length;$i++){
        $num=mt_rand(0,$len);
        $randstr .= $str[$num];
        }
        return $randstr;
    }

    protected function createSign($stringA) {
        \Log::info("------- stringA --------", [$stringA]);
        $stringSignTemp = $stringA . "&key=renzheng840728chengboren15081900";
        $sign = strtoupper(md5($stringSignTemp));
        return $sign;
    }

    protected function createReSign($req,$sian_time) {

        $params = [
            'appId' => $req['appid'],
            'nonceStr' => $req['nonce_str'],
            'package' => "prepay_id=" . $req['prepay_id'],
            'signType' => "MD5",
            'timeStamp' => $sian_time,
            ];

            ksort($params);

        $stringA = "";
        foreach ($params as $k => $v) {
            $stringA = $stringA . "&" . $k . "=" . $v;
        }

        $StringTmp = ltrim($stringA, "&");
        $resign = $this->createSign($StringTmp);
        return $resign;
    }

    protected function getDateTime() {
        $date = date("Ymd");
        $time = date("his");
        $datetime = $date . $time;
        return $datetime;
    }

    protected function createTradeNo() {
        $trade_no = $this->getDateTime() . $this->createRand(6);
        return $trade_no;
    }


    public function onPayBack(Request $req) {

        $content = file_get_contents("php://input");
        $content = str_replace("\n","",$content);
        $params = $this->decodeXml($content);

        $sign_str = $params['sign'];
        unset($params['sign']);
        
        ksort($params);
        $str = "";
        foreach ($params as $k => $v) {
            $str .= "&".$k ."=" . $v;
        }
        $str .= "&key=renzheng840728chengboren15081900";
        $str = ltrim($str, "&");
        $sign_strTmp = strtoupper(md5($str));
        $updateTrade;
        if($sign_strTmp == $sign_str)
        {
            $trade1 = Trade::paySelect($params["out_trade_no"]);
            if($trade1->pay_status == 1){
                return  $trade1;
            }
            Trade::payUpdate($params["out_trade_no"]);
            $trade = Trade::paySelect($params["out_trade_no"]);
            return $trade;
        }
    }

    public function wxBack($decode,$resign,$sian_time) {
        return [
            "timeStamp" => $sian_time,
            "nonceStr"  => $decode['nonce_str'],
            "package" => "prepay_id=" . $decode['prepay_id'],
            "signType" => "MD5",
            "paySign" => $resign,
        ];
    }

    public function getOrderAll(Request $req) {
        $phone = $req->get('phone');
        $trades = Trade::getOrderAll($phone);
        if ($trades){
            $tradesTmp = [];
            foreach ($trades as $k => $v) {
                $count = 0;
                $childtrades = Childtrade::paySelectById($v->id);
                $childtradesTmp = [];
                foreach ($childtrades as $k1 => $v1) {
                    $activity = Campactivity::GetCampactivityById($v1->shopping_id);
                    $wxinfo = Wxinfo::GetWxinfoById($activity->wx_id);
                    if ($activity && $wxinfo){
                        $count += 1;
                        $childtradesTmp[] = [
                            "name" => $activity->name,
                            "title_pic" => Image::GetImageUrl($wxinfo->title_id),
                            "wx_id" => $wxinfo->id,
                            "activity_id" => $activity->id,
                            "charge" => $activity->charge,
                            "num" => $v1->num
                        ]; 
                    }
                }

                if ($count){
                    $tradesTmp[] = [
                        "out_trade_no" => $v->out_trade_no,
                        "date" => $v->updated_at->format('Y-m-d H:i:s'),
                        "trade_id" => $v->id,
                        "charge" => $v->total_fee,
                        "count" => $count,
                        "detail" => $childtradesTmp,
                        "address" => SendAddress::GetAddress($v->id),
                        "status" => $this->getStatus($v->pay_status,$v->use_status)                       
                    ];
                }
            }
            return  $tradesTmp;
        }
    }

    public function getOrderUnPay(Request $req) {
        $phone = $req->get('phone');
        $trades = Trade::getOrderUnPay($phone);
        if ($trades){
            $tradesTmp = [];
            foreach ($trades as $k => $v) {
                $count = 0;
                $childtrades = Childtrade::paySelectById($v->id);
                $childtradesTmp = [];
                foreach ($childtrades as $k1 => $v1) {
                    $activity = Campactivity::GetCampactivityById($v1->shopping_id);
                    $wxinfo = Wxinfo::GetWxinfoById($activity->wx_id);
                    if ($activity && $wxinfo){
                        $count += 1;
                        $childtradesTmp[] = [
                            "name" => $activity->name,
                            "title_pic" => Image::GetImageUrl($wxinfo->title_id),
                            "wx_id" => $wxinfo->id,
                            "activity_id" => $activity->id,
                            "charge" => $activity->charge,
                            "num" => $v1->num
                        ]; 
                    }
                }

                if ($count){
                    $tradesTmp[] = [
                        "out_trade_no" => $v->out_trade_no,
                        "date" => $v->updated_at->format('Y-m-d H:i:s'),
                        "trade_id" => $v->id,
                        "charge" => $v->total_fee,
                        "count" => $count,
                        "detail" => $childtradesTmp,
                        "status" => '待付款'
                        ];
                }
            }
            return  $tradesTmp;
        }
    }

    public function getOrderUnsend(Request $req) {
        $phone = $req->get('phone');
        $trades = Trade::getOrderUnUse($phone);
        if ($trades){
            $tradesTmp = [];
            foreach ($trades as $k => $v) {
                $count = 0;
                $childtrades = Childtrade::paySelectById($v->id);
                $childtradesTmp = [];
                foreach ($childtrades as $k1 => $v1) {
                    $activity = Campactivity::GetCampactivityById($v1->shopping_id);
                    $wxinfo = Wxinfo::GetWxinfoById($activity->wx_id);
                    if ($activity && $wxinfo){
                        $count += 1;
                        $childtradesTmp[] = [
                            "name" => $activity->name,
                            "title_pic" => Image::GetImageUrl($wxinfo->title_id),
                            "wx_id" => $wxinfo->id,
                            "activity_id" => $activity->id,
                            "charge" => $activity->charge,
                            "num" => $v1->num
                            
                        ]; 
                    }
                }

                if ($count){
                    $tradesTmp[] = [
                        "out_trade_no" => $v->out_trade_no,
                        "date" => $v->updated_at->format('Y-m-d H:i:s'),
                        "trade_id" => $v->id,
                        "charge" => $v->total_fee,
                        "count" => $count,
                        "detail" => $childtradesTmp,
                        "status" => '待发货'
                        ];
                }
            }
            return  $tradesTmp;
        }
    }

    public function getOrderSend(Request $req) {
        $phone = $req->get('phone');
        $trades = Trade::getOrderUse($phone);
        if ($trades){
            $tradesTmp = [];
            foreach ($trades as $k => $v) {
                $count = 0;
                $childtrades = Childtrade::paySelectById($v->id);
                $childtradesTmp = [];
                foreach ($childtrades as $k1 => $v1) {
                    $activity = Campactivity::GetCampactivityById($v1->shopping_id);
                    $wxinfo = Wxinfo::GetWxinfoById($activity->wx_id);
                    if ($activity && $wxinfo){
                        $count += 1;
                        $childtradesTmp[] = [
                            "name" => $activity->name,
                            "title_pic" => Image::GetImageUrl($wxinfo->title_id),
                            "wx_id" => $wxinfo->id,
                            "activity_id" => $activity->id,
                            "charge" => $activity->charge,
                            "num" => $v1->num
                        ]; 
                    }
                }

                if ($count){
                    $tradesTmp[] = [
                        "out_trade_no" => $v->out_trade_no,
                        "date" => $v->updated_at->format('Y-m-d H:i:s'),
                        "trade_id" => $v->id,
                        "charge" => $v->total_fee,
                        "count" => $count,
                        "detail" => $childtradesTmp,
                        "status" => '待收货'
                        ];
                }
            }
            return  $tradesTmp;
        }
    }

    protected function getStatus($paystatus,$usestatus) {
        if ($paystatus == 0){
            return '待付款';
        }else if ($paystatus == 1){
            if ($usestatus == 0){
                return '待发货';
            }else if ($usestatus == 1){
                return '待收货';
            }
        }
    }

    protected function getColor($paystatus,$usestatus) {
        if ($paystatus == 0){
            return 'red';
        }else if ($paystatus == 1){
            if ($usestatus == 0){
                return 'blue';
            }else if ($usestatus == 1){
                return 'green';
            }
        }
    }

    public function hideOrder(Request $req) {
        $id = $req->get('id');
        $trade = Trade::hideOrder($id);
        if ($trade) {
            return  $trade;
        }
    }

    public function useUpdate(Request $req) {
        $id = $req->get('id');
        $trade = Trade::useUpdate($id);
        if ($trade) {
            return  $trade;
        }
    }

    protected function insertAddress($id,$trade_id) {
        $address = Address::GetAddressById($id);
        $params =[
            'name' => $address->name,
            'phone' => $address->phone,
            'province' => $address->province,
            'city' => $address->city,
            'area' => $address->area,
            'detail' => $address->detail, 
            'trade_id' => $trade_id
        ];
        SendAddress::addressInsert($params);
    }

    public function onPayForCert(Request $req) {

        $urlLogin = "https://api.weixin.qq.com/sns/jscode2session";
        $paramsLogin = [
        	'appid' => "wx25428722a46f46c4",
            'secret' => "13accb5ad3afe802ed10360210b52633",
            'js_code' => $req->get('js_code'),
            'grant_type' => "authorization_code",
        ];
        try {
            $resultLogin = GuzzleHttp::guzzleGet($urlLogin, $paramsLogin);
            if (isset($resultLogin['errcode'])) {
                return [
                    "errcode" => $resultLogin['errcode'],
                    "errmsg" => "无效登录信息",
                ];
            }
            $openid = $resultLogin['openid'];
            $session_key = $resultLogin['session_key'];

            if ($openid && $session_key) {
                $campactivity = Campactivity::GetCampactivityById($req->get('detail_id'));
                $urlPay = "https://api.mch.weixin.qq.com/pay/unifiedorder";
                $params = [
                    'appid' => $paramsLogin["appid"],
                    'body' => $req->get('body'),
                    'mch_id' => "1547227511",
                    'nonce_str' => $this->createRand(32),
                    'notify_url' => "https://www.gfcamps.cn/onPayBack",
                    'openid' => $openid,
                    'out_trade_no'=> $this->createTradeNo(),
                    'spbill_create_ip' => $req->getClientIp(),
                    'total_fee' => $req->get('charge') * 100,
                    'trade_type' => "JSAPI",
                    ];

                    ksort($params);

                    $stringA = "";
                    foreach ($params as $k => $v) {
                        $stringA = $stringA . "&" . $k . "=" . $v;
                    }
                    $stringA = ltrim($stringA, "&");

                    $appid = $params["appid"];
                    $mch_id = $params["mch_id"];
                    $nonce_str = $params["nonce_str"];
                    $body = $params["body"];
                    $out_trade_no = $params["out_trade_no"];
                    $total_fee = $params["total_fee"];
                    $spbill_create_ip = $req->getClientIp();
                    $notify_url = $params["notify_url"];
                    $trade_type = $params["trade_type"];
                    $sign = $this->createSign($stringA);


                    $data = "<xml>
                    <appid>$appid</appid>
                    <body>$body</body>
                    <mch_id>$mch_id</mch_id>
                    <nonce_str>$nonce_str</nonce_str>
                    <notify_url>$notify_url</notify_url>
                    <openid>$openid</openid>
                    <out_trade_no>$out_trade_no</out_trade_no>
                    <spbill_create_ip>$spbill_create_ip</spbill_create_ip>
                    <total_fee>$total_fee</total_fee>
                    <trade_type>$trade_type</trade_type>
                    <sign>$sign</sign>
                 </xml>";
                 \Log::info("-----------pay", [$data]);
                 $trade = [
                    'out_trade_no' => $params["out_trade_no"],
                    'body' => $params["body"],
                    'detail_id' => 0,
                    'total_fee' => $params["total_fee"] * 0.01,
                    'phone' => $req->get('phone')
                 ];
                 $tradeNew = Trade::payInsert($trade);
                 $this->certsInsert($req->get('certInfo'), $tradeNew->id);
                 $this->insertAddress($req->get('address_id'),$tradeNew->id);
                 $resultPay = GuzzleHttp:: postXml($urlPay, $data);
                 $decode = $this->decodeXml($resultPay);
                 if ($decode["result_code"] == "SUCCESS")
                 {
                    $sian_time = (string)time();
                    $resign = $this->createReSign($decode,$sian_time);
                    return $this->wxBack($decode,$resign,$sian_time);
                 }
                 else if($decode["result_code"] == "FAIL")
                 {
                     return [
                        "errcode" => $decode["err_code"],
                        "errmsg" => $decode["err_code_des"],
                     ];
                 }

            }

        } catch (\Exception $e) {
            // 异常处理
            \Log::info("----------", [$e]);
            return [
                "code" => $e->getCode(),
                "msg"  => $e->getMessage(),
                "data" => [],
            ];
        }
    }

    protected function certsInsert($certInfo,$trade_id) {
        $arryCert = preg_split("/@/",$certInfo);
        $charge = 0;
        foreach ($arryCert as $v) {
            $item = $v;
            $arryItem = preg_split("/,/",$item);
            $id = $arryItem[0];
            $num = $arryItem[1];
            $childtrade = [
                'shopping_id' => $id,
                'num' => $num,
                'trade_id' => $trade_id
             ];
            Childtrade::payInsert($childtrade);
        }
    }
}
