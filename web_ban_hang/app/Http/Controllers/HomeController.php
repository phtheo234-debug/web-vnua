<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $title = "Trang chủ";
        $name = "Thảo";
        return view('home', compact('title', 'name'));
    }
}
