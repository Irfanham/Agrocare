<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use DB;
use Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'comment' => 'required'
        ]);
        $data = [
            'post_id' => $request->post_id,
            'user_id' => Auth::user()->id,
            'comment' => $request->comment,
            'c_date' => now('6.0').date(''),
        ];

        DB::table('comments')->insert($data);

        $notify = ['message'=>'Commented', 'alert-type'=>'success'];
        return redirect(url()->previous().'#post'.$request->post_id)->with($notify);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $comment = DB::table('comments')->where('id', $id)->first();
        $post = DB::table('posts')->where('id', $comment->post_id)->first();

        DB::table('comments')->where('id', $id)->delete();

        $notify = ['message'=>'Comment deteted', 'alert-type'=>'success'];
        return redirect(url()->previous().'#post'.$post->id)->with($notify);
    }
}
