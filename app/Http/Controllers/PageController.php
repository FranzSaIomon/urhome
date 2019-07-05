<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class PageController extends Controller
{
    public function __construct() {
        if (auth()->check()) {
            $user = auth()->user();
            
            if ($user->broker_information != null) {
                if($user->broker_information->is_expired()) {
                    $user->broker_information->SubscriptionID = null;
                    $user->broker_information->SubscriptionStart = null;
                    $user->broker_information->save();

                    return redirect('/paypal')->with(['title' => 'Subscription', 'nolanding' => 'nolanding', 'message' => true]);
                }
            }
        }
    }
    public function index() { return view("home")->with('title', 'Home'); }
    public function about() { return view("about")->with('title', 'About Us'); }
    public function contact() { return view("contact")->with('title', 'Contact Us'); }
    public function search() { return view("properties.search")->with(['title' => 'Property Search', 'nolanding' => 'nolanding']); }
    public function logout() { Auth::logout(); return redirect()->back(); }
    public function login() { return view('auth.login'); }

    public function invalid() { return redirect('/'); }
}
