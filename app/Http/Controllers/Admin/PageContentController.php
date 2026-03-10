<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\Request;

class PageContentController extends Controller
{
    /**
     * The pages we support with their display info.
     */
    private static array $pages = [
        'home'    => ['label' => 'Home',    'icon' => 'fa-house',           'desc' => 'Hero, sections titles, newsletter text'],
        'about'   => ['label' => 'About',   'icon' => 'fa-circle-info',     'desc' => 'Mission, stats, values, team members'],
        'guide'   => ['label' => 'Guide',   'icon' => 'fa-map',             'desc' => 'Hero, guide cards, pro tip banner'],
        'contact' => ['label' => 'Contact', 'icon' => 'fa-envelope',        'desc' => 'Hero, contact info, social links'],
        'blog'    => ['label' => 'Blog',    'icon' => 'fa-newspaper',       'desc' => 'Blog listing page hero section'],
    ];

    /**
     * List all editable pages.
     */
    public function index()
    {
        $pages = collect(static::$pages)->map(function ($info, $slug) {
            $info['slug']  = $slug;
            $info['count'] = PageContent::where('page', $slug)->count();
            $info['route'] = route('admin.pages.edit', $slug);

            // Public URL
            $info['public_url'] = match ($slug) {
                'home'    => route('home'),
                'about'   => route('about'),
                'guide'   => route('guide'),
                'contact' => route('contact'),
                'blog'    => route('blog.index'),
                default   => '#',
            };

            return $info;
        });

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show edit form for a specific page.
     */
    public function edit(string $page)
    {
        abort_unless(array_key_exists($page, static::$pages), 404);

        $pageInfo = static::$pages[$page];
        $fields   = PageContent::forPage($page);

        $publicUrl = match ($page) {
            'home'    => route('home'),
            'about'   => route('about'),
            'guide'   => route('guide'),
            'contact' => route('contact'),
            'blog'    => route('blog.index'),
            default   => '#',
        };

        return view('admin.pages.edit', compact('page', 'pageInfo', 'fields', 'publicUrl'));
    }

    /**
     * Save all content for a page.
     */
    public function update(Request $request, string $page)
    {
        abort_unless(array_key_exists($page, static::$pages), 404);

        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            PageContent::where('page', $page)
                ->where('key', $key)
                ->update(['value' => $value]);
        }

        // Clear cache for this page
        PageContent::clearCache($page);

        return back()->with('success', static::$pages[$page]['label'] . ' page content updated successfully.');
    }
}
