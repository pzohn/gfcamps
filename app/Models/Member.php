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
}