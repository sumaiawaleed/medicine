<?php

namespace App\Http\Controllers\Auth;

use App\Functions\SMSclass;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Engineer;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class LoginController extends Controller
{

    use AuthenticatesUsers;
    protected $loginPath = '/auth/login';
    protected $redirectPath = '/home';
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showAdminLoginForm()
    {
        $data['title'] = __('site.login');
        return view('auth.admin_login', compact('data'));
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('__tala_')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect(route(env('DASH_URL') . '.index'));
        }
        return back()->withInput($request->only('email', 'remember'));
    }

}
