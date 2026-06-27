<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Material;
use App\Models\Project;
use App\Models\Service;
use App\Models\SocialLink;
use App\Models\Contact;
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

        $recentServices = Service::latest()->take(5)->get();
        $recentProjects = Project::orderBy('sort_order', 'desc')->take(5)->get();
        $recentPosts = BlogPost::latest()->take(5)->get();
        $recentContacts = Contact::where('is_active', true)->get();

        return view('admin.dashboard', compact(
            'servicesCount',
            'categoriesCount',
            'materialsCount',
            'projectsCount',
            'blogPostsCount',
            'socialLinksCount',
            'contactsCount',
            'recentServices',
            'recentProjects',
            'recentPosts',
            'recentContacts'
        ));
    }
}
