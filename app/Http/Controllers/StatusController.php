<?php

namespace App\Http\Controllers;

use App\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
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
        $request->validate([
            'user_id'=>'required',
            'content'=>'required',
        ]);
        $status = Status::create([
            'user_id' => $request->input('user_id'),
            'content' => $request->input('content'),
        ]);
        
        
        $date = Status::latest()->first();
        $dates= $date->created_at->diffForHumans();
        
        return response()->json([
            'success'=>true,
            'message'=>'status berhasil disimpan',
            'data'=>$status,
            'date'=>$dates
            
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function show(Status $status,$id)
    {
        //
        $status = Status::find($id);
        return response()->json([
            'success'=>true,
            'message' => 'Detail data Status',
            'data'=>$status
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function edit(Status $status)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Status $status)
    {
        //
        $id=$request->id;
        $request->validate([
            'user_id'=>'required',
            'content'=>'required',
        ]);
        $status = Status::where('id',$id)->update([
            'user_id' => $request->input('user_id'),
            'content' => $request->input('content'),
        ]);
        return response()->json([
            'success'=>true,
            'message'=>'Status berhasil diupdate',
            'data'=>$status
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Status $status)
    {
        //
        Status::where('id',$id)->delete();
        return response()->json([
            'success'=>true,
            'message'=>'Status berhasil dihapus'
        ]);
    }
}
