<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use App\Models\Uploadpic;


class FileController extends Controller
{
    public function upload(Request $req)
    {
        \Log::info("1111111111111111111",[]);
         $file = $req->file('file');
         if($file->isValid()) {
            \Log::info("12222222222222",[]);
            $originalName = $file->getClientOriginalName(); // 文件原名
            $ext = $file->getClientOriginalExtension();     // 扩展名
            $realPath = $file->getRealPath();   //临时文件的绝对路径
            $type = $file->getClientMimeType();

            $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
            $bool = Storage::disk('public')->put($filename, file_get_contents($realPath));
            //var_dump($bool);
            if ($bool){
                $url = "https://www.gfcamps.cn/public/forum".$filename;
                $params = [
                    "url" => $url,
                    "parent_id" => $req->get('parent_id')
                ];
                //Uploadpic::InsertPic($params);
            }
        }
       
    }
}
