<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campactivity;
use App\Models\Image;
use App\Models\Show;

class CampactivityController extends Controller
{
    public function getCampactivities() {
        $campactivities = Campactivity::GetCampactivities();
        $campactivitiesTmp = [];
        foreach ($campactivities as $k => $v) {
            $campactivitiesTmp[] = [
            "id" => $v->id,
            "name" => $v->name,
	        "title_pic" => Image::GetImage($v->title_pic_id)->url,
	        "file" => Image::GetImage($v->title_pic_id)->file
            ];
        }
        return  $campactivitiesTmp;
    }

    public function getCampactivitiesByLittleType(Request $req) {
        $type_id = $req->get('type_id');
        $campactivities = Campactivity::GetCampactivitiesByTypeId($type_id);
        $campactivitiesTmp = [];
        foreach ($campactivities as $k => $v) {
            $campactivitiesTmp[] = [
            "id" => $v->id,
            "name" => $v->name,
	        "title_pic" => Image::GetImage($v->title_pic_id)->url,
	        "file" => Image::GetImage($v->title_pic_id)->file
            ];
        }
        return  $campactivitiesTmp;
    }

    public function getShowsByType(Request $req) {
        $type_id = $req->get('type_id');
        $shows = Show::GetShowsByType($type_id);
        $campactivities = Campactivity::GetCampactivitiesByTypeId($type_id);
        $campactivitiesTmp = [];
        foreach ($shows as $k => $v) {
            $id = $v->activity_id;
            $activity = Campactivity::GetCampactivityById($id);
            $campactivitiesTmp[] = [
            "id" => $activity->id,
            "name" => $activity->name,
	        "title_pic" => Image::GetImage($activity->title_pic_id)->url,
	        "file" => Image::GetImage($activity->title_pic_id)->file
            ];
        }
        return  $campactivitiesTmp;
    }
}
