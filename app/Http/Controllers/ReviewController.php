<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('user')->where('status', 'approved')->latest()->get();
        return view('reviews', compact('reviews'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'text' => $request->text,
            'rating' => $request->rating,
            'status' => 'moderation',
        ]);

        return redirect()->route('reviews.index')->with('success', 'Отзыв отправлен на модерацию');
    }
}