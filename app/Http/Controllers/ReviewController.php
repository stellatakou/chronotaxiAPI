<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index(){
        return response()->json(Review::all());
    }

    public function store(Request $request){
        $this->validate($request, [
            "client_id" => "required",
            "driver_id" => "required",
            "note"      => "required",
        ]);

        $review = new Review();
        $review->fill($request->all());
        $review->save();
        return response()->json($review);
    }

    public function show($id){
        $review = Review::with(["client", "driver"])->findOrFail($id);
        return response()->json($review);
    }

    public function destroy($id){
        $review = Review::with(["client", "driver"])->findOrFail($id);
        $review->delete();
        return reponse()->json(["reponse" => "ok"]);
    }
}
