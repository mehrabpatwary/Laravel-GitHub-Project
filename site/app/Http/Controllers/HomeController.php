<?php

namespace App\Http\Controllers;

use App\Models\ContactModel;
use App\Models\CourseModel;
use App\Models\ProjectsModel;
use App\Models\ReviewModel;
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
        $projectsData=json_decode(ProjectsModel::orderBy('id', 'desc')->limit(10)->get());
        $reviewData=json_decode(ReviewModel::orderBy('id', 'desc')->limit(10)->get());

        return view('Home', [
            'serviceData'=>$serviceData,
            'coursesData'=>$coursesData,
            'projectsData'=>$projectsData,
            'reviewData'=>$reviewData
        ]);
    }

    function HomeContact(Request $request):int{
        $contact_name = $request->input('contact_name');
        $contact_mobile = $request->input('contact_mobile');
        $contact_email = $request->input('contact_email');
        $contact_msg = $request->input('contact_msg');

        $result = ContactModel::insert([
            'contact_name'=> $contact_name,
            'contact_mobile'=> $contact_mobile,
            'contact_email'=> $contact_email,
            'contact_msg'=> $contact_msg
        ]);
        if($result==true) return 1;
        else return 0;
    }
}
