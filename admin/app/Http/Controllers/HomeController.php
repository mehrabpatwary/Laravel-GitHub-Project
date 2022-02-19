<?php

namespace App\Http\Controllers;

use App\Models\ContactModel;
use App\Models\CoursesModel;
use App\Models\ProjectsModel;
use App\Models\ReviewModel;
use App\Models\ServicesModel;
use App\Models\VisitorModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function HomeIndex(){
        $totalVisitor=VisitorModel::count();
        $totalServices=ServicesModel::count();
        $totalCourses=CoursesModel::count();
        $totalProjects=ProjectsModel::count();
        $totalContact=ContactModel::count();
        $totalReview=ReviewModel::count();
        return view('Home', [
            'totalVisitor'=>$totalVisitor,
            'totalServices'=>$totalServices,
            'totalCourses'=>$totalCourses,
            'totalProjects'=>$totalProjects,
            'totalContact'=>$totalContact,
            'totalReview'=>$totalReview,
            ]);
    }
}
