<?php

namespace App\Http\Controllers;

use App\Models\ReviewModel;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    function reviewIndex(){
        return view('Review');
    }

    function getReviewData(){

        return json_encode(ReviewModel::orderBy('id', 'desc')->get());
    }

    function reviewDelete(Request $request): int{
        $id = $request->input('id');
        $result = ReviewModel::where('id', '=', $id)->delete();
        if($result==true){
            return 1;
        }else return 0;
    }

    function SetDataInInputField(Request $request){
        $id = $request->input('id');
        $result = ReviewModel::where('id', '=', $id)->get();
        return json_encode($result);
    }

    function reviewUpdate(Request $request):int {
        $id = $request->input('id');
        $review_name = $request->input('name');
        $review_des = $request->input('desc');
        $review_img = $request->input('image');

        $result = ReviewModel::where('id', $id)
            ->update([
                'name'=>$review_name,
                'desc'=>$review_des,
                'img'=>$review_img
            ]);
        if($result==true){
            return 1;
        }else return 0;
    }

    function reviewAdd(Request $request):int {
        $review_name = $request->input('name');
        $review_des = $request->input('desc');
        $review_img = $request->input('img');

        $result = ReviewModel::insert([
            'name'=>$review_name,
            'desc'=>$review_des,
            'img'=>$review_img
        ]);
        if($result==true){
            return 1;
        }else return 0;
    }
}


