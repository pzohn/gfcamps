<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Message extends Model {
        
    public static function messageInsert($params) {
        $message = new self;
        $message->phone = array_get($params,"phone");
        $message->content = array_get($params,"content");
        $message->save();
        return $message;
    }
}