<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CoursesModel;

class CoursesController extends Controller
{
    function CoursesIndex(){
        return view('Courses');
    }

    function getCoursesData(){
         
        return json_encode(CoursesModel::orderBy('id', 'desc')->get());
     }

     function CoursesDelete(Request $request){
        $id = $request->input('id');
        $result = CoursesModel::where('id', '=', $id)->delete();
        if($result==true){
            return 1;
        }else return 0;
    }

    function SetDataInInputField(Request $request){
        $id = $request->input('id');
         $result = CoursesModel::where('id', '=', $id)->get();
         return json_encode($result);
    }

    function CoursesUpdate(Request $request){
        $id = $request->input('id');
        $course_name = $request->input('course_name');
        $course_des = $request->input('course_des');
        $course_fee = $request->input('course_fee');
        $course_total_enroll = $request->input('course_total_enroll');
        $course_total_class = $request->input('course_total_class');
        $course_link = $request->input('course_link');
        $course_img = $request->input('course_img');

        $result = CoursesModel::where('id', $id)
        ->update([
            'course_name'=>$course_name,
            'course_des'=>$course_des,
            'course_fee'=>$course_fee,
            'course_total_enroll'=>$course_total_enroll,
            'course_total_class'=>$course_total_class,
            'course_link'=>$course_link,
            'course_img'=>$course_img
        ]);
         if($result==true){
             return 1;
         }else return 0;
    }

    function CoursesAdd(Request $request){
        $course_name = $request->input('course_name');
        $course_des = $request->input('course_des');
        $course_fee = $request->input('course_fee');
        $course_total_enroll = $request->input('course_total_enroll');
        $course_total_class = $request->input('course_total_class');
        $course_link = $request->input('course_link');
        $course_img = $request->input('course_img');
        $result = CoursesModel::insert([
            'course_name'=>$course_name,
            'course_des'=>$course_des,
            'course_fee'=>$course_fee,
            'course_total_enroll'=>$course_total_enroll,
            'course_total_class'=>$course_total_class,
            'course_link'=>$course_link,
            'course_img'=>$course_img
        ]);
        if($result==true){
            return 1;
        }else return 0;
     }
}
