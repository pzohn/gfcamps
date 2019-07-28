<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Trade extends Model {
        
    public static function payInsert($params) {

        $trade = new self;
        $trade->out_trade_no = array_get($params,"out_trade_no");
        $trade->body = array_get($params,"body");
        $trade->detail_id = array_get($params,"detail_id");
        $trade->total_fee = array_get($params,"total_fee");
        $trade->phone = array_get($params,"phone");
        $trade->save();
        return $trade;
    }

    public static function payUpdate($out_trade_no) {
        $trade = Trade::where("out_trade_no", $out_trade_no)->first();
        if ($trade) {
            if($trade->pay_status == 1)
            {
                return $trade;
            }
            $trade->pay_status = 1;
            $trade->update();
            return $trade;
        }
    }

    public static function paySelect($out_trade_no) {
        $trade = Trade::where("out_trade_no", $out_trade_no)->first();
        if ($trade) {
            return $trade;
        }
    }

    public static function getOrderAll($phone) {
        $trades = Trade::where("phone", $phone)->where("show_status", 1)->orderBy('updated_at', 'desc')->get();
        if ($trades) {
            return $trades;
        }
    }

    public static function getOrderUnPay($phone) {
        $trades = Trade::where("phone", $phone)->where("show_status", 1)->where("pay_status", 0)->orderBy('updated_at', 'desc')->get();
        if ($trades) {
            return $trades;
        }
    }

    public static function getOrderUnUse($phone) {
        $trades = Trade::where("phone", $phone)->where("show_status", 1)->where("pay_status", 1)->where("use_status", 0)->orderBy('updated_at', 'desc')->get();
        if ($trades) {
            return $trades;
        }
    }

    public static function getOrderUse($phone) {
        $trades = Trade::where("phone", $phone)->where("show_status", 1)->where("pay_status", 1)->where("use_status", 1)->orderBy('updated_at', 'desc')->get();
        if ($trades) {
            return $trades;
        }
    }
}