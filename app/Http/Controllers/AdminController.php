<?php

namespace App\Http\Controllers;
use Mail;
use File;
use Image;

use App\Log;
use App\User;
use App\Advertisement;
use App\Property;
use App\PropertyDocument;
use App\PanoramaRequest;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function check_admin(Request $request) {
        if (!(auth()->check() && auth()->user()->UserType == 3))
            return redirect('/');
    }

    public function brokers(Request $request) {
        $this->check_admin($request);
        return view("admin.brokers")->with(['title' => 'Broker Requests', 'nolanding' => 'nolanding']); 
    }

    public function logs(Request $request) {
        $this->check_admin($request);
        return view("admin.logs")->with(['title' => 'Audit Logs', 'nolanding' => 'nolanding']); 
    }

    public function logs_download(Request $request) {
        $this->check_admin($request);
        $echo = Log::orderBy("created_at", "ASC")->get();
        $str = "";

        foreach ($echo as $e) {
            $str .= "[" . $e->created_at . "] (USER " . $e->UserID . ") " . $e->Action . "\n";
        }

        Log::truncate();

        return response($str)
            ->header('Content-Type', 'text/plain');
    }

    public function requests(Request $request) {
        $this->check_admin($request);
        return view("admin.requests")->with(['title' => '360 Requests', 'nolanding' => 'nolanding']); 
    }

    public function reports(Request $request) {
        $this->check_admin($request);
        return view("admin.reports")->with(['title' => 'Reports', 'nolanding' => 'nolanding']); 
    }
    
    public function advertisements(Request $request) {
        $this->check_admin($request);
        return view("admin.advertisements")->with(['title' => 'Advertisements', 'nolanding' => 'nolanding']); 
    }

    public function add_advertisements(Request $request) {
        $this->check_admin($request);

        $ad = new Advertisement();
        
        $ad->Title = $request['Title'];

        foreach ($request->file() as $key => $value) {
            $folder = public_path('img/advertisements/');
            $imageName = time(). $key . '.' . $value->getClientOriginalExtension();

            if (!File::exists($folder)) {
                File::makeDirectory($folder, 0775, true, true);
            }

            $location = public_path('img/advertisements/' . $imageName);
            Image::make($value)->save($location);
            $ad->Image = '/img/advertisements/' . $imageName;
        }

        $ad->save();

        return redirect()->back()->with('success', true);
    }

    public function remove_advertisement(Request $request, Advertisement $ad) {
        $this->check_admin($request);
        
        $ad->delete();
        File::delete(public_path($ad->Image));

        return redirect()->back()->with('info', true);
    }

    public function verify(Request $request, User $user) {
        $this->check_admin($request);


        Log::log(auth()->id(), "Admin verified User{". $user->id . "}");
        $user->Status = 1;
        $user->save();
        
        Mail::send('mail.verified', array('name' => 'UrHome', 'user' => $user), function ($message) use ($user) {
            $message->from('urhome.company@gmail.com', 'UrHome');
            $message->sender('urhome.company@gmail.com', 'UrHome');
            $message->to($user->email, $user->FirstName . ' ' . $user->LastName);
            $message->subject('You have been verified!');
            $message->priority(3);
        });

        return redirect()->back()->with(['success' => true]);
    }

    public function add_panorama(Request $request, Property $property) {
        $this->check_admin($request);

        $d3 = array();
        foreach($request->file() as $key => $value) {
            $folder = public_path('img/' . $property->UserID . '/' . $property->id . '/3d/');
            $imageName = time(). $key . '.' . $value->getClientOriginalExtension();

            if (!File::exists($folder)) {
                File::makeDirectory($folder, 0775, true, true);
            }

            $location = public_path('img/' . $property->UserID . '/' . $property->id . '/3d/' . $imageName);
            $image = Image::make($value);
            $image->resize($image->height() * 2, null)->save($location);
            array_push($d3, '/img/' . $property->UserID . '/' . $property->id . '/3d/' . $imageName);
        }

        $doc = $property->property_document;
        $doc->Images = array("3d" => $d3, "regular" => $doc->Images["regular"]);
        $doc->save();

        Log::log(auth()->id(), "Admin added panorama phots for Property{". $property->id . "}");
        PanoramaRequest::where('PropertyID', $property->id)->delete();
        Mail::send('mail.panorama', array('name' => 'UrHome', 'property' => $property), function ($message) use ($property) {
            $message->from('urhome.company@gmail.com', 'UrHome');
            $message->sender('urhome.company@gmail.com', 'UrHome');
            $message->to($property->user->email, $property->user->FirstName . ' ' . $property->user->LastName);
            $message->subject('Property - ' . $property->Name . " has been updated.");
            $message->priority(3);
        });

        return redirect()->back()->with(['success' => true]);
    }
}
