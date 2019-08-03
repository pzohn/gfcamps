<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Member extends Model {
        
    public static function memberInsert($params) {

        $member = new self;
        $member->name = array_get($params,"name");
        $member->email = array_get($params,"email");
        $member->phone = array_get($params,"phone");
        $member->save();
        return $member;
    }

    public static function memberSelect($phone) {
        $member = Member::where("phone", $phone)->first();
        if ($member) {
            return $member;
        }
    }

    public static function memberInsertPhone($phone) {
        $member = new self;
        $member->phone = $phone;
        $member->save();
        return $member;
    }

    public static function CollectUpdate($phone,$collect_ids) {
        $member = Member::where("phone", $phone)->first();
        if ($member) {
            $member->collect_ids = $collect_ids;
            $member->update();
            return $member;
        }
    }

    public static function memberUpdatePhone($params) {
        \Log::info("----------", [$params]);
        \Log::info("----------", [array_get($params,"phone")]);
        \Log::info("----------", [array_get($params,"name")]);
        \Log::info("----------", [array_get($params,"email")]);
        \Log::info("----------", [array_get($params,"sex")]);
        \Log::info("----------", [array_get($params,"age")]);
        $member = Member::where("phone", array_get($params,"phone"))->first();
        if ($member) {
            \Log::info("9999999");
            $member->name = array_get($params,"name");
            $member->email = array_get($params,"email");
            $member->sex = array_get($params,"sex");
            $member->age = array_get($params,"age");
            $member->update();
            return $member;
        }
    }
}