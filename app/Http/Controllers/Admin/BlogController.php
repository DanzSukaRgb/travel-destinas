<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    private const CATEGORIES = ['Travel Tips', 'Destination Guide', 'Adventure', 'Food & Culture', 'Budget Travel', 'Luxury Travel'];

    public function index(Request $request)
    {
        $query = Blog::query();

        if ($search = $request->get('q')) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
        }

        if ($cat = $request->get('category')) {
            $query->where('category', $cat);
        }

        $blogs      = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $categories = self::CATEGORIES;

        return view('admin.blog.index', compact('blogs', 'categories', 'search'));
    }

    public function create()
    {
        $categories = self::CATEGORIES;
        return view('admin.blog.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'cover_image'  => 'nullable|url',
            'category'     => 'required|in:' . implode(',', self::CATEGORIES),
            'excerpt'      => 'required|string|max:400',
            'body'         => 'required|string',
            'author'       => 'required|string|max:100',
            'read_time'    => 'nullable|string|max:30',
            'is_published' => 'boolean',
        ]);

        $data['slug']         = Blog::generateSlug($data['title']);
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? now() : null;

        Blog::create($data);

        return redirect()->route('admin.blog.index')
            ->with('success', "Blog post \"{$data['title']}\" created.");
    }

    public function edit(Blog $blog)
    {
        $categories = self::CATEGORIES;
        return view('admin.blog.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'cover_image'  => 'nullable|url',
            'category'     => 'required|in:' . implode(',', self::CATEGORIES),
            'excerpt'      => 'required|string|max:400',
            'body'         => 'required|string',
            'author'       => 'required|string|max:100',
            'read_time'    => 'nullable|string|max:30',
            'is_published' => 'boolean',
        ]);

        $wasPublished     = $blog->is_published;
        $data['is_published'] = $request->boolean('is_published');

        if ($data['is_published'] && !$wasPublished) {
            $data['published_at'] = now();
        }
        if (!$data['is_published']) {
            $data['published_at'] = null;
        }

        $blog->update($data);

        return redirect()->route('admin.blog.index')
            ->with('success', "Blog post \"{$blog->title}\" updated.");
    }

    public function destroy(Blog $blog)
    {
        $title = $blog->title;
        $blog->delete();
        return redirect()->route('admin.blog.index')
            ->with('success', "Blog post \"{$title}\" deleted.");
    }
}
