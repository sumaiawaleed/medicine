<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
     public function index()
    {
       return "soon";
    }

    public function keys(){
        $exitCode = Artisan::call('passport:install');
    }
}
