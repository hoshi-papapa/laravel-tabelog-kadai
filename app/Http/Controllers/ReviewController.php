<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
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
            'rating' => 'required',
            'comment' => 'required'
        ]);

        $review = new Review();
        $review->rating = $request->input('rating');
        $review->comment = $request->input('comment');
        $review->user_id = Auth::user()->id;
        $review->store_id = $request->input('store_id');
        $review->save();

        return back();
    }
}