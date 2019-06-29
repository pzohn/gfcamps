<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campactivity;
use App\Models\Image;
use App\Models\Show;
use App\Models\Bigtype;
use App\Models\Littletype;
use App\Models\Schedule;
use App\Models\Campdt;
use App\Models\Special;
use App\Models\Carousel;
use App\Models\Camp;
use App\Models\City;
use App\Models\Campimage;
use App\Models\Zizhiimage;


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

    public function getCampactivitiesByCounty(Request $req) {
        $county_id = $req('country_id');
        $campactivities = Campactivity::GetCampactivityByCounty($county_id);
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
            "swiper_pics" => $this->getCarousels($activity->type_id),
            "campdesc" => $activity->prologue,
            "present_pics" => $this->getUrls($activity->present_pic_ids),
            "schedule_ids" => $this->getSchedule($activity->schedule_ids),
            "activitytimes" => $this->getActivityTimes($activity->time_ids),
            "address" => $activity->address,
            "object" => $activity->object,
            "charge" => $activity->charge,
            "charge_parent" => $activity->charge_parent,
            "preferential" => $activity->preferential,
            "food" => $activity->food,
            "traffic" => $activity->traffic,
            "safe" => $activity->safe,
            "other" => $activity->other,
            "desc" =>$activity->desc,
            "charge_info" =>$activity->charge_info,
            "stay" =>$activity->stay,
            "special" => $this->getSpecial($activity->special_ids)
        ];
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
            "title_pic_id" => $v->title_pic_id,
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
            "title_pic_id" => $activity->title_pic_id,
            "image" => Image::GetImage($activity->title_pic_id),
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
            $schedule = Schedule::GetSchedule($schedule_ids);
            if ($schedule){
                $schedules[] = [
                        "title" => $schedule->title,
                        "desc" => $schedule->desc,
                        "pics" => $this->getUrls($schedule->pic_ids)
                ];
                return $schedules;
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

    protected function getActivityTimes($time_ids) {
        $pos = strpos($time_ids, '@');
        if ($pos == false){
            $activityTime = Campdt::GetActivityTime($time_ids);
            if ($activityTime){
                $activityTimes[] = [
                    $activityTime 
                ];
                return $activityTimes;
            }
        }else{
            $arry = preg_split("/@/",$time_ids);
            $uactivityTimes = [];
            foreach ($arry as $v) {
                $activityTimes[] = [
                    Campdt::GetActivityTime($v)
                ];
            }
            return $activityTimes;
        }
    }

    protected function getSpecial($special_ids) {
        $pos = strpos($special_ids, '@');
        if ($pos == false){
            $special = Special::GetSpecial($special_ids);
            if ($special){
                $specials[] = [
                        "title" => $special->title,
                        "content" => $special->content,
                        "pics" => $this->getUrls($special->pic_ids),
                        "id" => $special_ids
                    ];
                return $specials;
            }
        }else{
            $arry = preg_split("/@/",$special_ids);
            $specials = [];
            foreach ($arry as $v) {
                $special = Special::GetSpecial($v);
                $specials[] = [
                    "title" => $special->title,
                    "content" => $special->content,
                    "pics" => $this->getUrls($special->pic_ids),
                    "id" => $special->id
                ];
            }
            return $specials;
        }
    }

    protected function getCarousels($typeid) {
        $carousels = Carousel::GetCarousels($typeid);
        $urls = [];
        foreach ($carousels as $v) {
            $urls[] = [
                "lunbo/" . $v->url . ".jpg"
            ];
        }
        return $urls;
    }

    public function getCamps() {
        $camps = Camp::GetCamps();
        $campsTmp = [];
        foreach ($camps as $k => $v) {
            $campsTmp[] = [
            "id" => $v->id,
	        "info" => $v->info,
            "main" => $v->main,
            "city" => City::GetCity($v->city_id)->name,
            "logo" => Campimage::GetImageUrl($v->logo_pic_id)
            ];
        }
        return  $campsTmp;
    }

    public function getCampById(Request $req) {
        $id = $req->get('id');
        $camp = Camp::GetCampById($id);
        return [
            "title_pic" => Campimage::GetImageUrl($camp->title_pic_id),
            "weixin_pic" => Campimage::GetImageUrl($camp->weixin_pic_id),
            "address" => $camp->address,
            "phone" => $camp->phone,
            "email" => $camp->email,
            "info" => $this->getInfo($camp->info),
            "zizhi" => $this->getZizhi($camp->good_pic_ids),
            "name" => $camp->name
        ];
    }

    protected function getZizhi($good_pic_ids) {
        $pos = strpos($good_pic_ids, '@');
        if ($pos == false){
            $zizhi = Zizhiimage::GetImageUrl($special_ids);
            if ($zizhi){
                $zizhis[] = [
                    $zizhi
                    ];
                return $zizhis;
            }
        }else{
            $arry = preg_split("/@/",$good_pic_ids);
            $zizhis = [];
            foreach ($arry as $v) {
                $zizhi = Zizhiimage::GetImageUrl($v);
                $zizhis[] = [
                    $zizhi
                ];
            }
            return $zizhis;
        }
    }

    protected function getInfo($info) {
        $pos = strpos($info, '<br>');
        if ($pos == false){
            $infoTmp = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $info;
            return $infoTmp;
        }else{
            $arry = preg_split("<br>",$info);
            $infoTmp = "";
            $i = 0;
            foreach ($arry as $v) {
                if($i > 0){
                    $str = "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $v;
                }
                $str = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $v;
                $infoTmp = $infoTmp . $str;
                $i ++;
            }
            return $infoTmp;
        }
    }
}
