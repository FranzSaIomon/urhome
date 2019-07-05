<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('/');
    }
}
