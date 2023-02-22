<?php

namespace App\Http\Controllers;

use Auth;
use Input;
use App\Comunity;
use App\User;
use App\Status;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class FarmerController extends Controller
{
    //
    public function index(){
        return view("farmer.feedf");
    }


    public function profilePage(User $user){
        $user = Auth::user();
        $status = Status::with('users')->latest()->get();
        foreach($status as $c){
            $c->content= Str::limit($c->content, 150);
            
        }
        $friend = Comunity::with('users')->latest()->take(5)->get();
        $consult =User::where('role_id',2)->get();
        // return $user;
        return view("farmer.profile", compact('user','status','friend','consult'));
    }


    public function profile(User $user){
        $user = Auth::user();
        // return $user;
        return view("farmer.editProfile", compact('user'));
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
        return redirect('/feedf')->with('message','Profile Updated');
        
        
    }

    public function changeCover(User $user, Request $request){

        // var_dump($request->file('image'));
        $request->validate([
            'image'=>'file|image|max:2048',
        ]);
        
        $id = Auth::user()->id;

        $user->update($request->only([
            'cover_photo'
        ]));
        $request->file('image')->storeAs('/img', $request->file('image')->hashName(),'public');

        $user_update=array_filter([
           
           'cover_photo'=>$request->file('image')->hashName()
        ]);
        
        // $user->save();
        User::where('id',$id)->update($user_update);
        return redirect('/profilepage')->with('message','Profile Updated');
        
        
    }

    public function changePhoto(User $user, Request $request){

        // var_dump($request->file('image'));
        $request->validate([
            'image'=>'file|image|max:2048',
        ]);
        
        $id = Auth::user()->id;

        $user->update($request->only([
            'photo_profile'
        ]));
        $request->file('image')->storeAs('/img', $request->file('image')->hashName(),'public');

        $user_update=array_filter([
           'photo_profile'=>$request->file('image')->hashName()
        ]);
        
        // $user->save();
        User::where('id',$id)->update($user_update);
        return redirect('/profilepage')->with('message','Profile Updated');
        
        
    }
}
