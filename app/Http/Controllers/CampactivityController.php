<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campactivity;
use App\Models\Image;
use App\Models\Show;
use App\Models\Bigtype;
use App\Models\Littletype;
use App\Models\Schedule;

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

    public function getCampactivityById(Request $req) {
        $id = $req->get('id');
        $activity = Campactivity::GetCampactivityById($id);
        $bigId = Littletype::GetBigId($activity->type_id);
        return [
            "swiper_pics" => $this->getUrls($activity->swiper_pic_ids),
            "campdesc" => Bigtype::GetContent($bigId),
            "present_pics" => $this->getUrls($activity->present_pic_ids),
            "schedule_ids" => $this->getSchedule($activity->schedule_ids)
        ];
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

    protected function getUrls($url_ids) {
        $pos = strpos($url_ids, '@');
        if ($pos == false){
            $url = Image::GetImageUrl($url_ids);
            if ($url){
                $urls[] = [
                    $url 
                ];
                return $urls;
            }
        }else{
            $arry = preg_split("/@/",$url_ids);
            $urls = [];
            foreach ($arry as $v) {
                $urls[] = [
                    Image::GetImageUrl($v)
                ];
            }
            return $urls;
        }
    }

    protected function getSchedule($schedule_ids) {
        $pos = strpos($schedule_ids, '@');
        if ($pos == false){
            $schedule = Schedule::GetSchedule($url_ids);
            if ($schedule){
                $schedules[] = [
                    [
                        "title" => $schedule->title,
                        "desc" => $schedule->desc,
                        "pics" => $this->getUrls($schedule->pic_ids)
                    ]
                ];
                return $urls;
            }
        }else{
            $arry = preg_split("/@/",$schedule_ids);
            $schedules = [];
            foreach ($arry as $v) {
                $schedule = Schedule::GetSchedule($v);
                $urls[] = [
                    "title" => $schedule->title,
                    "desc" => $schedule->desc,
                    "pics" => $this->getUrls($schedule->pic_ids)
                ];
            }
            return $urls;
        }
    }
}
