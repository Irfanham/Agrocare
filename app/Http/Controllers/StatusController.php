<?php

namespace App\Http\Controllers;

use App\Status;
use Auth;
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
    //    dd($request->all());
        //
        $validator = \Validator::make($request->all(),[
            'user_id'=>'required',
            'content'=>'required',
            'image'=>'sometimes|image'
        ]);
        if ($validator->fails()) return response()->json([
            'status'=>400,
            'error'=>$validator->errors()->first()
        ]);

        if (!$request->image && !$request->content)return response()->json([
            'status'=>400,
            'error'=>'Must Select Image Or Write Text First'
        ]);
        $inputs = $request->all();
        if ($request->image){
            $inputs['image'] = \Storage::putFile('public/img',$request->image);
            $inputs['image'] = str_replace('public/','',$inputs['image']);
        }

        $post = auth()->user()->statuses()->create($inputs);
        $date = Status::latest()->first();
        $dates= $date->created_at->diffForHumans();
        $user = Auth::user();
        return response()->json([
            'success'=>true,
            'message'=>'status berhasil disimpan',
            'data'=>$post,
            'date'=>$dates,
            'user'=>$user
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
        $validator = \Validator::make($request->all(),[
            'user_id'=>'required',
            'content'=>'required',
            'image'=>'sometimes|image'
        ]);
        if ($validator->fails()) return response()->json([
            'status'=>400,
            'error'=>$validator->errors()->first()
        ]);

        if (!$request->image && !$request->content)return response()->json([
            'status'=>400,
            'error'=>'Must Select Image Or Write Text First'
        ]);

        $inputs = $request->all();
        if ($request->image){
            $inputs['image'] = \Storage::putFile('public/img',$request->image);
            $inputs['image'] = str_replace('public/','',$inputs['image']);
        }


        $date = Status::latest()->first();
        $dates= $date->created_at->diffForHumans();
        $user = Auth::user();
        $post = auth()->user()->statuses()->update($inputs);
        return response()->json([
            'success'=>true,
            'message'=>'status berhasil diupdate',
            'data'=>$post,
            'date'=>$dates,
            'user'=>$user
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
