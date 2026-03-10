<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Destination;
use App\Models\Newsletter;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'destinations'       => Destination::count(),
            'featured'           => Destination::where('is_featured', true)->count(),
            'popular'            => Destination::where('is_popular', true)->count(),
            'blogs'              => Blog::count(),
            'blogs_published'    => Blog::where('is_published', true)->count(),
            'newsletters'        => Newsletter::count(),
        ];

        $recent_destinations = Destination::latest()->limit(6)->get();
        $recent_blogs        = Blog::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_destinations', 'recent_blogs'));
    }
}
