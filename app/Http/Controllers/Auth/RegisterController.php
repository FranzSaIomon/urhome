<?php

namespace App\Http\Controllers\Auth;

use App\Log;
use App\User;
use App\UserDocument;
use App\BrokerInformation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use File;
use Image;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'FirstName' => ['required', 'string', 'max:255'],
            'LastName' => ['required', 'string', 'max:255'],
            'ContactNo' => ['required', 'string', 'max:20', 'mobile'],
            'BirthDate' => ['required', 'date_format:Y-m-d', 'before:today', 'adult'],
            'LotNo' => ['required', 'integer', 'min:0'],
            'Street' => ['required', 'string', 'max:255'],
            'City' => ['required', 'string', 'max:255'],
            'Country' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'FirstName' => $data['FirstName'],
            'LastName' => $data['LastName'],
            'BirthDate' => $data['BirthDate'],
            'ContactNo' => $data['ContactNo'],
            'LotNo' => $data['LotNo'],
            'Street' => $data['Street'],
            'City' => $data['City'],
            'Country' => $data['Country'],
            'email' => $data['email'],
            'UserType' => $data['UserType'],
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function register(Request $request) {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));
        $doc = new UserDocument();
        $files = [];
        $imgLoc = 'https://www.winhelponline.com/blog/wp-content/uploads/2017/12/user.png';

        foreach ($request->file() as $key => $value) {
            if (strpos($key, 'file') !== false && $user->UserType == 2) {
                $folder = public_path('files/' . $user->id . '/broker_files/');
                $fileName = time(). $key . '.' . $value->getClientOriginalExtension();

                if (!File::exists($folder)) {
                    File::makeDirectory($folder, 0775, true, true);
                }
                $value->move(public_path('files/' . $user->id . '/broker_files/'), $fileName);
                array_push($files,'/files/' . $user->id . '/broker_files/' . $fileName);
            } else {
                $folder = public_path('img/' . $user->id . '/profile/');
                $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
                
                if (!File::exists($folder)) {
                    File::makeDirectory($folder, 0775, true, true);
                }
                
                $value->move(public_path('img/' . auth()->id() . '/profile/'), $imageName);
                $imgLoc = '/img/' . auth()->id() . '/profile/' . $imageName;
            }
        }

        if ($user->UserType == 2) { // if broker
            $user->Status = 2; // unverified broker
            $user->save();

            $info = new BrokerInformation();
            $info->UserID = $user->id;
            $info->save();
        }

        $user->ProfileImage = $imgLoc;
        $user->save();

        $doc->Files = $files;
        $doc->UserID = $user->id;
        $doc->save();

        Log::log($user->id, "User " . $user->id . " registered as a " . ($user->UserType == 2 ? " Broker" : " Client"));

        return $this->registered($request, $user)
                            ?: redirect($this->redirectPath());
    }
}
