<?php

namespace App\Http\Controllers;

use Auth;
use Input;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class AdminController extends Controller
{
    //
    public function index(){
        return view("admin.dashboard");
    }
    public function profile(User $user){
        $user = Auth::user();
        // return $user;
        return view("admin.editProfile", compact('user'));
    }
    public function userProfile(){
        $user=User::with('roles')->where('role_id',2)->orWhere('role_id',3)->paginate(10);
        // return $user;
        return view("admin.pengguna",compact('user'));

    }

    public function changeUserStatus(Request $request)
    {   

        $user = User::find($request->id);
        $user->status_ban = $request->status_ban;
        $user->save();
  
        return response()->json(['success'=>'User status change successfully.']);
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
        return redirect('/dashboard')->with('message','Profile Updated');
        
        
    }
    public function addUser(User $user, Request $request){
        $request->validate([
            'name' =>'required|min:4|string|max:255',
            'email'=>'required|email|string|max:255|unique:users',
            'username'=>'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user=User::create([
            
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role_id' => $request->input('role'),
            'nohp' => $request->input('nohp'),
            'alamat' => $request->input('alamat'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password'))
        ]);
        $data = User::with('roles')->where('role_id',2)->orWhere('role_id',3)->get();
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $data
        ]);



    }
    public function showUser($id){
        $user=User::with('roles')->where('role_id',2)->orWhere('role_id',3)->get();
        $data = $user->find($id);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data User',
            'data'    => $data  
        ]);


        
    }


    public function editUser(User $user,Request $request){
        $request->validate([
            'name' =>'required|min:4|string|max:255',
            'email'=>'required|email|string|max:255',
        ]);
        
        $id = $request->id;

        $user->update($request->only([
            'name', 'nohp','alamat','username','photo_profile'
        ]));

        $user_update=array_filter([
            'name'=>$request->get('name'),
            'email'=>$request->get('email'),
            'nohp'=>$request->get('nohp'),
           'alamat'=>$request->get('alamat'),
           'username'=>$request->get('username'),
        ]);
        
        // $user->save();
        User::where('id',$id)->update($user_update);
        $updated=User::with('roles')->where('role_id',2)->orWhere('role_id',3)->get();
        $data=$updated->find($id);
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diudapte!',
            'data'    => $data
        ]);
    }

    public function delUser($id){
        $user = User::where('id',$id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Post Berhasil Dihapus!.',
        ]);
        // return redirect('/pengguna')->with('success','Data telah dihapus.');
    }
}
