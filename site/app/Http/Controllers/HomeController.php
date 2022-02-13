<?php

namespace App\Http\Controllers;

use App\Models\CourseModel;
use App\Models\ServicesModel;
use App\Models\VisitorModel;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    function HomeIndex(){

        $USER_IP = $_SERVER['REMOTE_ADDR'];
        date_default_timezone_set('Asia/Dhaka');
        $timeDate = date('Y-m-d h:i:sa');

        VisitorModel::insert(['ip_address'=>$USER_IP, 'visit_time'=>$timeDate]);

        $serviceData=json_decode(ServicesModel::all());
        $coursesData=json_decode(CourseModel::orderBy('id', 'desc')->limit(6)->get());

        return view('Home', [
            'serviceData'=>$serviceData,
            'coursesData'=>$coursesData
        ]);
    }
}
