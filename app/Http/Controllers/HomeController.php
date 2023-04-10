<?php

namespace App\Http\Controllers;

use App\TravlePackage;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function index(Request $request){
        $items= TravlePackage::with(['galleries'])->get();
        return view('pages.home',[
           'items' => $items 
        ]);
    }
}
