<?php

namespace App\Http\Controllers;

use App\Models\Benefit;
use App\Models\Feature;
use App\Models\Feedback;
use App\Models\Partner;
use App\Models\Project;
use App\Models\Service;
use App\Models\Statistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
     public function index()
    {
        $data['title'] = __('site.home');
        $data['features'] = Feature::where('status',1)->get();
        $data['statistics'] = Statistic::where('status',1)->get()->take(4);
        $data['projects'] = Project::where('status',1)->get()->take(4);
        $data['benefits'] = Benefit::where('status',1)->get()->take(4);
        $data['companies'] = Partner::where('type',1)->where('status',1)->get()->take(4);
        $data['products'] = Partner::where('type',2)->where('status',1)->get()->take(4);

        return view('home',compact('data'));
    }
}
