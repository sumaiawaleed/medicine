<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SettingController extends Controller
{
    private function validate_page($request,$data = "")
    {
        $rules = array();
        foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties) {
            $rules += [$locale . '_title' => ['required']];
            $rules += [$locale . '_author' => ['required']];
            $rules += [$locale . '_description' => ['required']];
        }//end of for each

        $validator = Validator::make($request->all(), $rules);

        return $validator;

    }

    public function index(Request $request){
        $data['title'] = __('site.settings');
        $form_data = Setting::findOrFail(1);
        return view('dashboard.settings.index',compact('data','form_data'));
    }

    public function store(Request $request){
        $settings = Setting::findOrFail(1);
        $validator = $this->validate_page($request,$settings);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()

            ), 200);
        } else {
            $title_array = array();
            $description_array = array();
            $author_array = array();
            foreach(LaravelLocalization::getSupportedLocales() as $locale => $properties) {
                $t = $locale."_title";
                $title_array[$locale] = $request->$t;

                $s = $locale."_author";
                $author_array[$locale] = $request->$s;

                $d = $locale."_description";
                $description_array[$locale] = $request->$d;
            }



            $request_data = [
                'title' => json_encode($title_array,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
                'meta_title' => json_encode($title_array,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'linkedin' =>$request->linkedin,
                'youtube' =>$request->youtube,
                'meta_desc' => json_encode($description_array,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
                'author' => json_encode($author_array,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
            ];
            if ($request->image) {
                if($settings->logo != '') {
                    $path = 'public/uploads/site/' . $settings->logo;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
                Image::make($request->image)
                    ->save(public_path('uploads/site/' . $request->image->hashName()));
                $request_data['logo'] = $request->image->hashName();
            }

            $settings->update($request_data);
            return response()->json(array('success' => true), 200);
        }
    }
}
