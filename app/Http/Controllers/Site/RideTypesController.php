<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RideType;
use Carbon\Carbon;

class RideTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = RideType::all()->where("deleted_at", null);
        return view("ride_types.index", compact("types"));
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
        $this->validate($request, [
            "label" => "required"
        ]);
        $type = new RideType();
        $type->label = request("label");
        $type->save();
        return back()->withSuccess("Le type de trajet a bien été enregistré.");
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
        $type = RideType::findOrFail($id);
        return view("ride_types.edit", compact("type"));
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
        $this->validate($request, [
            "label" => "required"
        ]);
        $type = RideType::findOrFail($id);
        $type->label = request("label");
        $type->save();
        return back()->withSuccess("Le type de trajet a bien été mis à jour.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = RideType::findOrFail($id);
        $type->deleted_at = Carbon::now();
        $type->save();
        return back()->withSuccess("Le type de trajet a bien été supprimé.");
    }
}
