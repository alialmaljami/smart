<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisitorQuestion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VisitorQuestionController extends Controller
{
    public function index(): View
    {
        $questions = VisitorQuestion::latest()->get();
        return view('admin.visitor-questions.index', compact('questions'));
    }

    public function edit(VisitorQuestion $visitorQuestion): View
    {
        return view('admin.visitor-questions.edit', compact('visitorQuestion'));
    }

    public function update(Request $request, VisitorQuestion $visitorQuestion): RedirectResponse
    {
        $validated = $request->validate([
            'answer' => ['required', 'string'],
            'is_active' => ['boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $visitorQuestion->update($validated);

        return redirect()->route('admin.visitor-questions.index')->with('success', 'تم تحديث السؤال بنجاح');
    }

    public function destroy(VisitorQuestion $visitorQuestion): RedirectResponse
    {
        $visitorQuestion->delete();
        return redirect()->route('admin.visitor-questions.index')->with('success', 'تم حذف السؤال بنجاح');
    }

    public function toggleActive(VisitorQuestion $visitorQuestion): RedirectResponse
    {
        $visitorQuestion->update(['is_active' => !$visitorQuestion->is_active]);
        return redirect()->route('admin.visitor-questions.index')->with('success', 'تم تحديث الحالة بنجاح');
    }
}
