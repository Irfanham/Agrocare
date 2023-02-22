<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;

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
    protected $redirectTo = '/login';

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
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'photo_profile' => 'file|image|max:2048',
            'password' => ['required', 'string', 'min:8'],
        ],[ 'username.required' => 'Kolom wajib diisi',
        'username.unique' => 'Username sudah ada',
        'username.min' => 'Username minimal 3 karakter',
        'name.required' => 'Kolom wajib diisi',
        'name.min' => 'Nama minimal 3 karakter',
        'name.regex' => 'Nama tidak valid',
        'email.required' => 'Kolom wajib diisi',
        'email.email' => 'Email tidak valid',
        'email.unique' => 'Email sudah ada',
        'photo_profile.file' => 'Kolom wajib diisi',
        'photo_profile.image' => 'Wajib harus gambar',
        'photo_profile.max' => 'Gambar maksimal 2MB',
        'password.required' => 'Kolom wajib diisi',
        'password.min' => 'Password minimal 8 karakter',
        'password.string' => 'Password tidak valid',]);        
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
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id'=> $data['role'],
            'nohp' => $data['nohp'],
            'alamat' => $data['alamat'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
       
        User::create([
            
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role_id' => $request->input('role'),
            'nohp' => $request->input('nohp'),
            'alamat' => $request->input('alamat'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password'))
        ]);
    
        // event(new Registered($user = $this->create($request->all())));

        return redirect($this->redirectPath())->with('message', 'Berhasil');
    }

}


