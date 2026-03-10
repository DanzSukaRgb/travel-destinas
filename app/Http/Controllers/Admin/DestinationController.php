<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DestinationController extends Controller
{
    private const CATEGORIES = ['Beach', 'Mountain', 'City', 'Nature', 'Cultural', 'Adventure'];

    public function index(Request $request)
    {
        $query = Destination::query();

        if ($search = $request->get('q')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
        }

        if ($cat = $request->get('category')) {
            $query->where('category', $cat);
        }

        $destinations = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $categories   = self::CATEGORIES;

        return view('admin.destinations.index', compact('destinations', 'categories', 'search'));
    }

    public function create()
    {
        $categories = self::CATEGORIES;
        return view('admin.destinations.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:255',
            'country'           => 'required|string|max:100',
            'city'              => 'required|string|max:100',
            'category'          => 'required|in:' . implode(',', self::CATEGORIES),
            'image'             => 'required|url',
            'short_description' => 'required|string|max:300',
            'description'       => 'required|string',
            'best_time'         => 'nullable|string|max:100',
            'estimated_budget'  => 'nullable|string|max:100',
            'rating'            => 'required|numeric|between:0,5',
            'reviews_count'     => 'required|integer|min:0',
            'is_featured'       => 'boolean',
            'is_popular'        => 'boolean',
            'latitude'          => 'nullable|numeric',
            'longitude'         => 'nullable|numeric',
            'gallery'           => 'nullable|string',
            'highlights'        => 'nullable|string',
            'activities'        => 'nullable|string',
        ]);

        $data['slug']       = Str::slug($data['name']) . '-' . time();
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_popular']  = $request->boolean('is_popular');

        // Parse multiline textarea → JSON arrays
        $data['gallery']    = $this->parseLines($request->input('gallery'));
        $data['highlights'] = $this->parseLines($request->input('highlights'));
        $data['activities'] = $this->parseLines($request->input('activities'));

        Destination::create($data);

        return redirect()->route('admin.destinations.index')
            ->with('success', "Destination \"{$data['name']}\" created successfully.");
    }

    public function edit(Destination $destination)
    {
        $categories = self::CATEGORIES;
        return view('admin.destinations.edit', compact('destination', 'categories'));
    }

    public function update(Request $request, Destination $destination)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:255',
            'country'           => 'required|string|max:100',
            'city'              => 'required|string|max:100',
            'category'          => 'required|in:' . implode(',', self::CATEGORIES),
            'image'             => 'required|url',
            'short_description' => 'required|string|max:300',
            'description'       => 'required|string',
            'best_time'         => 'nullable|string|max:100',
            'estimated_budget'  => 'nullable|string|max:100',
            'rating'            => 'required|numeric|between:0,5',
            'reviews_count'     => 'required|integer|min:0',
            'is_featured'       => 'boolean',
            'is_popular'        => 'boolean',
            'latitude'          => 'nullable|numeric',
            'longitude'         => 'nullable|numeric',
            'gallery'           => 'nullable|string',
            'highlights'        => 'nullable|string',
            'activities'        => 'nullable|string',
        ]);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_popular']  = $request->boolean('is_popular');
        $data['gallery']     = $this->parseLines($request->input('gallery'));
        $data['highlights']  = $this->parseLines($request->input('highlights'));
        $data['activities']  = $this->parseLines($request->input('activities'));

        $destination->update($data);

        return redirect()->route('admin.destinations.index')
            ->with('success', "Destination \"{$destination->name}\" updated successfully.");
    }

    public function destroy(Destination $destination)
    {
        $name = $destination->name;
        $destination->delete();
        return redirect()->route('admin.destinations.index')
            ->with('success', "Destination \"{$name}\" deleted.");
    }

    // ── Helpers ────────────────────────────────────────────────
    private function parseLines(?string $input): array
    {
        if (!$input) return [];
        return array_values(array_filter(array_map('trim', explode("\n", $input))));
    }
}
