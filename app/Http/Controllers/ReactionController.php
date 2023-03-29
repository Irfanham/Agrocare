<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use App\Reaction;
use Illuminate\Http\Request;

class ReactionController extends Controller
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
        $data = [
            'user_id' => Auth::user()->id,
            'post_id' => $request->post_id
        ];

        DB::table('reactions')->insert($data);
        return redirect(url()->previous().'#post'.$request->post_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reaction  $reaction
     * @return \Illuminate\Http\Response
     */
    public function show(Reaction $reaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reaction  $reaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Reaction $reaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reaction  $reaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reaction $reaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reaction  $reaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reaction $reaction,$id)
    {

        //
        $like = DB::table('reactions')->where('id', $id)->first();
        $post = DB::table('posts')->where('id', $like->post_id)->first();

        DB::table('reactions')->where('id', $id)->delete();

        return redirect(url()->previous().'#post'.$post->id);
    }
}
