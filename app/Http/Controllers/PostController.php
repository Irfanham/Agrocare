<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $post = Post::with('users')->latest()->get();
        foreach($post as $p){
            $p->content= Str::limit($p->content, 150);
            
        }
        $news = Post::with('users')->latest()->take(5)->get();
        $consult=User::where('role_id',2)->get();
        // return $data;
        return view("admin.berita",compact('post','news','consult'));
        

    }

    public function indexe()
    {
        //
        $post = Post::with('users')->latest()->get();
        foreach($post as $p){
            $p->content= Str::limit($p->content, 150);
            
        }
        $news = Post::with('users')->latest()->take(5)->get();
        $consult=User::where('role_id',2)->get();
        // return $data;
        return view("expert.berita",compact('post','news','consult'));
        

    }

    public function indexf()
    {
        //
        $post = Post::with('users')->latest()->get();
        foreach($post as $p){
            $p->content= Str::limit($p->content, 150);
            
        }
        $news = Post::with('users')->latest()->take(5)->get();
        $consult=User::where('role_id',2)->get();
        // return $data;
        return view("farmer.berita",compact('post','news','consult'));
        

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Post $post,Request $request)
    {
        //
        $request->validate([
            'user_id'=>'required',
            'title'=>'required',
            'content'=>'required',
        ]);
        $post = Post::create([
            'user_id'=>$request->input('user_id'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);
        
        
        $date = Post::latest()->first();
        $dates= $date->created_at->diffForHumans();
        
        return response()->json([
            'success'=>true,
            'message'=>'Artikel berhasil disimpan',
            'data'=>$post,
            'date'=>$dates
            
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post,$id)
    {
        //
        $post = Post::find($id);
        return response()->json([
            'success'=>true,
            'message' => 'Detail data Post',
            'data'=>$post
        ]);

    }

    public function readPost(Post $post,$id)
    {
        //
        $post = Post::where('id',$id)->first();
        $news = Post::with('users')->latest()->take(5)->get();
        $consult=User::where('role_id',2)->get();
        // return($post);
        return view("admin.baca",compact('post','news','consult'));

    }

    public function reade(Post $post,$id)
    {
        //
        $post = Post::where('id',$id)->first();
        $news = Post::with('users')->latest()->take(5)->get();
        $consult=User::where('role_id',2)->get();
        // return($post);
        return view("expert.baca",compact('post','news','consult'));

    }

    public function readf(Post $post,$id)
    {
        //
        $post = Post::where('id',$id)->first();
        $news = Post::with('users')->latest()->take(5)->get();
        $consult=User::where('role_id',2)->get();
        // return($post);
        return view("farmer.baca",compact('post','news','consult'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
        $id=$request->id;
        $request->validate([
            'title'=>'required',
            'content'=>'required',
        ]);
        $post = Post::where('id',$id)->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);
        return response()->json([
            'success'=>true,
            'message'=>'Artikel berhasil diupdate',
            'data'=>$post
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Post::where('id',$id)->delete();
        return response()->json([
            'success'=>true,
            'message'=>'Artikel berhasil dihapus'
        ]);
        
    }
}
