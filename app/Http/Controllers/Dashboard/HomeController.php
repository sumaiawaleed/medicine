<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $data['title'] = __('site.home');
        return view('dashboard.index', compact('data'));
    }
}
