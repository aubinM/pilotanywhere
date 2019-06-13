<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ca_enregistrement;
use App\Http\Controllers\Auth;
use Carbon\Carbon;
use App\User;


class RecordsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $enregistrements = Ca_enregistrement::all();
        
        
        
//        dd($materiel->materiel_autonome->name);
         return view('layouts.enregistrements', compact('enregistrements'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $enregistrement = Ca_enregistrement::find($id);
        $user_id = \Auth::user()->id;
        $enregistrement->checked_by = $user_id;
        $checked_user_name = User::find($user_id)->login;
        $enregistrement->checked_at = Carbon::now();
        $enregistrement->save();
        
        $enregistrements = Ca_enregistrement::all();
//        return response()->json();
        return view('layouts.enregistrements', compact('enregistrements','checked_user_name'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $comment = $request->input('comment');
        $id = $request->input('comment_id');
        $enregistrement = Ca_enregistrement::find($id);
        $enregistrement->commentaire = $comment;
        $enregistrement->save();
        $enregistrements = Ca_enregistrement::all();
        
        

        return view('layouts.enregistrements', compact('enregistrements'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
