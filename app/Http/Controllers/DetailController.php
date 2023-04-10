<?php

namespace App\Http\Controllers;

use App\TravlePackage;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function index(Request $request, $slug){
        $item=TravlePackage::with(['galleries'])->where('slug',$slug)->firstOrFail();
        return view('pages.detail',[
            'item' =>$item
        ]);
    }
}
