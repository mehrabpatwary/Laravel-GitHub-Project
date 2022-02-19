<?php

namespace App\Http\Controllers;

use App\Models\ProjectsModel;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    function ProjectsIndex(){
        $projectData=json_decode(ProjectsModel::orderBy('id', 'desc')->get());
        return view('Projects', ['projectData'=>$projectData]);
    }
}
