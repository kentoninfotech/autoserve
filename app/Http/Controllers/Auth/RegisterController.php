<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }



    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        if($data['email']==""){
            $email = "crmadmin@crmfct.org";
            $password = Hash::make("prayer22");
        }else{
            $email = $data['email'];
            $password = Hash::make($data['password']);
            
        }
        return User::create([
            'name' => $data['name'],
            'email' => $email,
            'gender' => $data['gender'],
            'dob' => $data['dob'],
            'age_group'=>$data['age_group'],
            'phone_number'=>$data['phone_number'],
            'password' => $password,
            'about' => $data['about'],
            'address' => $data['address'],
            'location' => $data['location'],
            'house_fellowship' => $data['house_fellowship'],
            'invited_by' => $data['invited_by'],
            'assigned_to' => $data['assigned_to'],
            'ministry' => $data['ministry'],
            'role'=>"Member",
            'status'=>$data['status']
        ]);
    }
}
