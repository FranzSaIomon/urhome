<?php

namespace App\Http\Controllers;

use App\User;
use App\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user)
    {
        if (!isset($user->id))
            if (auth()->check())
                $user = auth()->user();
            else
                return redirect('/');

        if ($user->Status != 0)
            return view('users.view')->with(['user' => $user, 'nolanding' => 'nolanding']);
        else
            return redirect('/');
    }

    

    public function is_deactivated(Request $request) {
        $validated = $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::all()->where('email', $request['email'])->first();
        
        if (isset($user)) {
            if (Hash::check($request['password'], $user->password)) {
                if ($user->Status == 0) {
                    return response()->json(["message" => "Your account has been deactivated. Please click <a href='users/reactivate/'>here</a> to reactivate your account"], 200);
                } else {
                    return response()->json([], 422);
                }
            } else {
                return response()->json(['errors' => ['email' => ['These credentials do not match our records.']]], 422);
            }
        } else {
            return response()->json(['errors' => ['email' => ['These credentials do not match our records.']]], 422);
        }
    }

    public function show_reactivate(Request $request) {
        if (!auth()->check()) {
            return view('users.reactivate')->with(['title' => 'Reactivate Account', 'nolanding' => 'nolanding']);
        } else {
            return redirect('/');
        }
    }

    public function reactivate(Request $request) {
        $validated = $this->validate($request, [
            'email' => 'required',
            'password' => 'required|confirmed'
        ]);

        $user = User::all()->where('email', $request['email'])->first();
        
        if (isset($user)) {
            if (Hash::check($request['password'], $user->password)) {
                if ($user->Status == 0) {
                    $user->Status = 1;
                
                    if ($user->user_type->id == 2) {
                        $properties = $user->property;
            
                        for ($i = 0; $i < count($properties); $i++) {
                            $properties[$i]->StatusID = 1;
                            $properties[$i]->save();
                        }
                    }

                    $user->save();
                    return response()->json(['message' => 'Your account has been reactivated. You may now login again.']);
                } else {
                    return response()->json(['message' => 'Your account is already activated']);
                }
            } else {
                return response()->json(['errors' => ['email' => ['These credentials do not match our records.']]], 422);
            }
        } else {
            return response()->json(['errors' => ['email' => ['These credentials do not match our records.']]], 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'FirstName' => ['required', 'string', 'max:255'],
            'LastName' => ['required', 'string', 'max:255'],
            'ContactNo' => ['required', 'string', 'max:20', 'mobile'],
            'Birthdate' => ['required', 'date_format:Y-m-d', 'before:today', 'adult'],
            'LotNo' => ['required', 'integer', 'min:0'],
            'Street' => ['required', 'string', 'max:255'],
            'City' => ['required', 'string', 'max:255'],
            'Country' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if (auth()->check() && auth()->user()->id == $user->id) {
            if (Hash::check($validated['password'], $user->password)) {
                $user->FirstName = $validated["FirstName"];
                $user->LastName = $validated["LastName"];
                $user->ContactNo = $validated["ContactNo"];
                $user->BirthDate = $validated["Birthdate"];
                $user->LotNo = $validated["LotNo"];
                $user->Street = $validated["Street"];
                $user->City = $validated["City"];
                $user->Country = $validated["Country"];
                $user->save();
    
                return response()->json(["success" => "<b>Success: </b> You have updated your profile."]);
            } 

            return response()->json(["errors" => ["password" => ["Incorrect password."]]], 422);
        }
           
        return response()->json(["errors" => ["password" => ["Something went wrong while updating your profile. Please try again later."]]], 422);
    }

    public function update_email(Request $request, User $user)
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string'],
        ]);

        if (Hash::check($validated['password'], $user->password)) {
            $user->email = $validated["email"];
            $user->email_verified_at = null;
            $user->sendEmailVerificationNotification();
            $user->save();

            return response()->json(["success" => "<b>Success: </b> You have changed your email address. Please check your new email address for a verification link."]);
        }
          
        return response()->json(["errors" => ["password" => ["Incorrect password."]]], 422);
    }

    public function update_password(Request $request, User $user)
    {
        $validated = $request->validate([
            'password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'confirmed'],
        ]);

        if (auth()->check() && auth()->user()->id == $user->id) {
            if (Hash::check($validated["password"], $user->password)){
                $user->password = Hash::make($validated['new_password']);
                $user->save();

                return response()->json(["success" => "<b>Success: </b> You have changed your password."]);
            }

            return response()->json(["errors" => ["password" => ["Incorrect password."]]], 422);
        }
          
        return response()->json(["errors" => ["password" => ["You do not have the valid credentials to continue."]]], 422);
    }

    public function resend_verification(Request $request, User $user)
    {
        if (auth()->check() && auth()->user()->id == $user->id && !$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();

            return response()->json(["success" => "<b>Info: </b> A new verification link has been sent to your email address."]);
        }
          
        return response()->json(["errors" => ["global" => ["Something went wrong while sending a new verification link. Please try again later."]]], 422);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->Status = 0;

        if ($user->user_type->id == 2) {
            $properties = $user->property;

            for ($i = 0; $i < count($properties); $i++) {
                $properties[$i]->StatusID = 2;
                $properties[$i]->save();
            }
        }

        $user->save();
        auth()->logout();
    }

    public function reports(Request $request) {
        if (auth()->check() && auth()->user()->broker_information->can(Feature::REPORT))
            return view('users.reports')->with(['nolanding' => 'nolanding']);
        else
            return redirect('/');
    }
}
