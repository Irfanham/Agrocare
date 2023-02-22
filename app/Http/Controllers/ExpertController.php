<?php

namespace App\Http\Controllers;

use Auth;
use Input;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ExpertController extends Controller
{
    //
    public function index(){
        return view("expert.feede");
    }

    public function profile(User $user){
        $user = Auth::user();
        // return $user;
        return view("expert.editProfile", compact('user'));
    }

    public function updateProfile(User $user, Request $request){

        // var_dump($request->file('image'));
        $request->validate([
            'name' =>'required|min:4|string|max:255',
            'email'=>'required|email|string|max:255',
            'image'=>'file|image|max:2048',
        ]);
        
        $id = Auth::user()->id;

        $user->update($request->only([
            'name', 'nohp','alamat','username','photo_profile'
        ]));
        $request->file('image')->storeAs('/img', $request->file('image')->hashName(),'public');

        $user_update=array_filter([
            'name'=>$request->get('name'),
            'email'=>$request->get('email'),
            'nohp'=>$request->get('nohp'),
           'alamat'=>$request->get('alamat'),
           'username'=>$request->get('username'),
           'photo_profile'=>$request->file('image')->hashName()
        ]);
        
        // $user->save();
        User::where('id',$id)->update($user_update);
        return redirect('/feede')->with('message','Profile Updated');
        
        
    }


}
