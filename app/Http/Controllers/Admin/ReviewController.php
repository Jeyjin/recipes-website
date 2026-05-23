<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('user')->latest()->get();
        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve($id)
    {
        Review::findOrFail($id)->update(['status' => 'approved']);
        return redirect()->route('admin.reviews.index')->with('success', 'Отзыв одобрен');
    }

    public function reject($id)
    {
        Review::findOrFail($id)->update(['status' => 'rejected']);
        return redirect()->route('admin.reviews.index')->with('success', 'Отзыв отклонён');
    }

    public function destroy($id)
    {
        Review::findOrFail($id)->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Отзыв удалён');
    }
}