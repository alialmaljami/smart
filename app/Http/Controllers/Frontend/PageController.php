<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Setting;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        $settings = Setting::all()->keyBy('key');
        return view('frontend.about', compact('settings'));
    }

    public function blog(): View
    {
        $posts = BlogPost::where('is_active', true)->latest()->paginate(9);
        return view('frontend.blog.index', compact('posts'));
    }

    public function blogPost(string $slug): View
    {
        $post = BlogPost::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('frontend.blog.show', compact('post'));
    }
}
