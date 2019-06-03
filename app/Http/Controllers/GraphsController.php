<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ca_enregistrement;
use App\Materiel_autonome;
use App\Ca_enregistrement_graphe_config;

class GraphsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Faire dernier par date debut plus tard
        $enregistrement = Ca_enregistrement::all()->last();
        $materiels = \App\Materiel_autonome::all();
        

        return view('layouts.graphes',compact('enregistrement','materiels'));
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
        $enregistrement = Ca_enregistrement::find($id);
        $enregistrement_last_id = Ca_enregistrement::all()->last()->id;
        $materiels = Ca_enregistrement::all()->last()->materiel_autonome->Ca_enregistrement_graphe_config;
 

         return view('layouts.graphes', compact('enregistrement','enregistrement_last_id','materiels'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
