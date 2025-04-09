<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    //
    public function index(){
        return response()->json(SocialMedia::all());
    }

    public function show($id){
        return response()->json(SocialMedia::find($id));
    }



}
