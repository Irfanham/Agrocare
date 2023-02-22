<?php

namespace App\Http\Controllers;

use App\Comunity;
use App\User;
use App\Status;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ComunityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $status = Status::with('users')->latest()->get();
        foreach($status as $c){
            $c->content= Str::limit($c->content, 150);
            
        }
        $friend = Comunity::with('users')->latest()->take(5)->get();
        $consult =User::where('role_id',2)->get();
        // return $data;
        return view("admin.komunitas",compact('status','friend','consult'));
    }

   
    public function indexf()
    {
        //
        $status = Status::with('users')->latest()->get();
        foreach($status as $c){
            $c->content= Str::limit($c->content, 150);
            
        }
        $friend = Comunity::with('users')->latest()->take(5)->get();
        $consult =User::where('role_id',2)->get();
        // return $data;
        return view("farmer.komunitas",compact('status','friend','consult'));
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comunity  $comunity
     * @return \Illuminate\Http\Response
     */
    public function show(Comunity $comunity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comunity  $comunity
     * @return \Illuminate\Http\Response
     */
    public function edit(Comunity $comunity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comunity  $comunity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comunity $comunity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comunity  $comunity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comunity $comunity)
    {
        //
    }
}
