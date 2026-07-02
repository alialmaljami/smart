<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Material;
use App\Models\Project;
use App\Models\Review;
use App\Models\Service;
use App\Models\SocialLink;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $servicesCount = Service::count();
        $categoriesCount = Category::where('type', 'material')->count();
        $materialsCount = Material::count();
        $projectsCount = Project::count();
        $blogPostsCount = BlogPost::count();
        $socialLinksCount = SocialLink::count();
        $contactsCount = Contact::count();
        $reviewsCount = Review::count();
        $pendingReviewsCount = Review::where('is_active', false)->count();
        $pendingMessagesCount = Contact::where('type', 'contact_message')->where('is_active', false)->count();

        $recentServices = Service::latest()->take(5)->get();
        $recentProjects = Project::orderBy('sort_order', 'desc')->take(5)->get();
        $recentPosts = BlogPost::latest()->take(5)->get();
        $recentContacts = Contact::where('is_active', true)->where('type', '!=', 'contact_message')->get();
        $recentMessages = Contact::where('type', 'contact_message')->latest()->take(5)->get();
        $pendingReviews = Review::where('is_active', false)->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'servicesCount',
            'categoriesCount',
            'materialsCount',
            'projectsCount',
            'blogPostsCount',
            'socialLinksCount',
            'contactsCount',
            'reviewsCount',
            'pendingReviewsCount',
            'pendingMessagesCount',
            'recentServices',
            'recentProjects',
            'recentPosts',
            'recentContacts',
            'recentMessages',
            'pendingReviews'
        ));
    }
}
