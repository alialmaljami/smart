<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(): View
    {
        $reviews = Review::latest()->get();
        return view('admin.reviews.index', compact('reviews'));
    }

    public function create(): View
    {
        return view('admin.reviews.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string'],
            'stars' => ['required', 'integer', 'min:1', 'max:5'],
            'image' => ['nullable', 'image', 'max:10240'],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('reviews', 'public');
        }

        Review::create($validated);

        return redirect()->route('admin.reviews.index')->with('success', 'تم إضافة التقييم بنجاح');
    }

    public function edit(Review $review): View
    {
        return view('admin.reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string'],
            'stars' => ['required', 'integer', 'min:1', 'max:5'],
            'image' => ['nullable', 'image', 'max:10240'],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('reviews', 'public');
        }

        $review->update($validated);

        return redirect()->route('admin.reviews.index')->with('success', 'تم تحديث التقييم بنجاح');
    }

    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'تم حذف التقييم بنجاح');
    }

    public function toggleActive(Review $review): RedirectResponse
    {
        $review->update(['is_active' => !$review->is_active]);
        return redirect()->route('admin.reviews.index')->with('success', 'تم تحديث حالة التقييم بنجاح');
    }
}