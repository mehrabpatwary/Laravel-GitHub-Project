<?php

namespace App\Http\Controllers;

use App\Models\ProjectsModel;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    function ProjectIndex(){
        return view('Projects');
    }

    function getProjectData(){

        return json_encode(ProjectsModel::orderBy('id', 'desc')->get());
     }

     function ProjectDelete(Request $request): int{
        $id = $request->input('id');
        $result = ProjectsModel::where('id', '=', $id)->delete();
        if($result==true){
            return 1;
        }else return 0;
    }

    function SetDataInInputField(Request $request){
        $id = $request->input('id');
         $result = ProjectsModel::where('id', '=', $id)->get();
         return json_encode($result);
    }

    function ProjectUpdate(Request $request):int {
        $id = $request->input('id');
        $project_name = $request->input('project_name');
        $project_des = $request->input('project_des');
        $project_link = $request->input('project_link');
        $project_image = $request->input('project_image');

        $result = ProjectsModel::where('id', $id)
        ->update([
            'project_name'=>$project_name,
            'project_des'=>$project_des,
            'project_link'=>$project_link,
            'project_img'=>$project_image
        ]);
         if($result==true){
             return 1;
         }else return 0;
    }

    function ProjectAdd(Request $request): int{
        $project_name = $request->input('project_name');
        $project_des = $request->input('project_des');
        $project_link = $request->input('project_link');
        $project_image = $request->input('project_image');

        $result = ProjectsModel::insert([
            'project_name'=>$project_name,
            'project_des'=>$project_des,
            'project_link'=>$project_link,
            'project_img'=>$project_image
        ]);
        if($result==true){
            return 1;
        }else return 0;
     }
}
