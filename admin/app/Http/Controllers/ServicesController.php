<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServicesModel;

class ServicesController extends Controller
{
    function ServiceIndex(){
        return view('Services');
    }

    function getServicesData(){
         
       return json_encode(ServicesModel::orderBy('id', 'desc')->get());
    }

    function ServiceDelete(Request $request){
         $id = $request->input('id');
         $result = ServicesModel::where('id', '=', $id)->delete();
         if($result==true){
             return 1;
         }else return 0;
     }

     function SetDataInInputField(Request $request){
        $id = $request->input('id');
         $result = ServicesModel::where('id', '=', $id)->get();
         return json_encode($result);
     }

     function ServiceUpdate(Request $request){
        $id = $request->input('id');
        $s_name = $request->input('s_name');
        $s_des = $request->input('s_des');
        $s_img = $request->input('s_img');

        $result = ServicesModel::where('id', $id)
        ->update(['service_name'=>$s_name, 'service_des'=>$s_des, 'service_img'=>$s_img]);
         if($result==true){
             return 1;
         }else return 0;
     }

     function ServiceAdd(Request $request){
        $s_add_name = $request->input('s_add_name');
        $s_add_des = $request->input('s_add_des');
        $s_add_img = $request->input('s_add_img');
        $result = ServicesModel::insert(['service_name'=>$s_add_name, 'service_des'=>$s_add_des, 'service_img'=>$s_add_img]);
        if($result==true){
            return 1;
        }else return 0;
     }
}
