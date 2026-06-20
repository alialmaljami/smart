<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\VisitorQuestion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VisitorQuestionController extends Controller
{
    public function index(): View
    {
        $questions = VisitorQuestion::where('is_active', true)->latest()->paginate(20);
        $breadcrumbs = [
            ['name' => __('Home'), 'url' => route('home')],
            ['name' => __('Questions & Answers'), 'url' => route('questions')],
        ];
        return view('frontend.questions.index', compact('questions', 'breadcrumbs'));
    }

    public function show(string $slug): View
    {
        $q = VisitorQuestion::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $related = VisitorQuestion::where('is_active', true)
            ->where('id', '!=', $q->id)
            ->inRandomOrder()
            ->limit(5)
            ->get();
        $breadcrumbs = [
            ['name' => __('Home'), 'url' => route('home')],
            ['name' => __('Questions & Answers'), 'url' => route('questions')],
            ['name' => $q->question, 'url' => route('q.show', $q->slug)],
        ];
        return view('frontend.questions.show', compact('q', 'related', 'breadcrumbs'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'question' => ['required', 'string', 'max:500'],
            'asked_by' => ['nullable', 'string', 'max:255'],
        ]);

        VisitorQuestion::create($validated);

        return redirect()->back()->with('success', __('Your question has been submitted successfully and will be answered soon!'));
    }
}
