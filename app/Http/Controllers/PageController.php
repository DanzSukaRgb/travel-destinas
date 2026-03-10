<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function guide()
    {
        return view('pages.guide');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function contactSend(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|min:10',
        ]);

        // In a real app, send email here
        return back()->with('success', 'Your message has been sent! We\'ll get back to you within 24 hours.');
    }

    public function blog(Request $request)
    {
        $query    = Blog::published();
        $category = $request->get('category');
        $search   = $request->get('q');

        if ($category) $query->byCategory($category);
        if ($search)   $query->where('title', 'like', "%{$search}%");

        $blogs      = $query->orderByDesc('published_at')->paginate(9)->withQueryString();
        $categories = ['Travel Tips', 'Destination Guide', 'Adventure', 'Food & Culture', 'Budget Travel', 'Luxury Travel'];

        return view('pages.blog.index', compact('blogs', 'categories', 'category', 'search'));
    }

    public function blogShow(string $slug)
    {
        $blog    = Blog::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $related = Blog::published()
            ->where('category', $blog->category)
            ->where('id', '!=', $blog->id)
            ->limit(3)
            ->get();

        return view('pages.blog.show', compact('blog', 'related'));
    }
}
