<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Test extends Model {

    public static function GetTest($id) {
        $test = Test::where("id", $id)->first();
        if ($test) {
            return $test;
        }
    }

    public static function GetTests() {
        $tests = Test::get();
        if ($tests) {
            return $tests;
        }
    }

    public static function writeTest($params) {

        $postitem = new self;
        $postitem->intvar = array_get($params,"intvar");
        $postitem->text = array_get($params,"text");
        $postitem->save();
        return $postitem;
    }
}