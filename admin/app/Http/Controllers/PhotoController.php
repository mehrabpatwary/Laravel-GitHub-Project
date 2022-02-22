<?php

namespace App\Http\Controllers;

use App\Models\PhotoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    function photoIndex(){
        return view('PhotoGallery');
    }

    function photoJSON(){
        return PhotoModel::take(4)->get();
    }

    function photoJSONId(Request $request){
        $FirstId = $request->id;
        $LastID = $FirstId+4;
        //$FirstId = $FirstId+1;
        return PhotoModel::where('id', '>', $FirstId)->where('id', '<=', $LastID)->get();
    }

    function photoDelete(Request $request){
        $id = $request->input('id');
        $location = $request->input('location');

        $photoArray = (explode('/', $location));
        $photoName = end($photoArray);
        $deletePhotoFile = Storage::delete('public/'.$photoName);
        return PhotoModel::where('id', '=', $id)->delete();

    }

    function photoUpload(Request $request){
        $photoPath = $request->file('photo')->store('public');

        $photoName = (explode('/', $photoPath))[1];
        $host = $_SERVER['HTTP_HOST'];
        $location = "http://".$host."/storage/".$photoName;

        return PhotoModel::insert(['location' =>$location]);
    }
}
