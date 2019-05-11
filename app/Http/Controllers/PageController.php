<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class PageController extends Controller
{
    public function index() { return view("home")->with('title', 'Home'); }
    public function about() { return view("about")->with('title', 'About Us'); }
    public function contact() { return view("contact")->with('title', 'Contact Us'); }
    public function search() { return view("properties.search")->with(['title' => 'Property Search', 'nolanding' => 'nolanding']); }
    public function logout() { Auth::logout(); return redirect('/'); }
    public function login() {return view('auth.login');}
}
