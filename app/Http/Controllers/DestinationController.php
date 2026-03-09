<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DestinationController extends Controller
{
    // ── Web Pages ────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query    = Destination::query();
        $category = $request->get('category');
        $search   = $request->get('q');
        $sort     = $request->get('sort', 'rating');

        if ($category) $query->byCategory($category);
        if ($search)   $query->search($search);

        $sortMap = [
            'rating'  => ['rating', 'desc'],
            'name'    => ['name',   'asc'],
            'popular' => ['reviews_count', 'desc'],
        ];
        [$col, $dir] = $sortMap[$sort] ?? ['rating', 'desc'];
        $query->orderBy($col, $dir);

        $destinations = $query->paginate(9)->withQueryString();

        $categories = ['All', 'Beach', 'Mountain', 'City', 'Nature', 'Cultural', 'Adventure'];

        return view('destinations.index', compact('destinations', 'categories', 'category', 'search', 'sort'));
    }

    public function show(string $slug)
    {
        $destination = Destination::where('slug', $slug)->firstOrFail();

        $related = Destination::where('category', $destination->category)
            ->where('id', '!=', $destination->id)
            ->limit(3)
            ->get();

        return view('destinations.show', compact('destination', 'related'));
    }

    // ── AJAX Endpoints ───────────────────────────────────────────

    /**
     * AJAX: Search destinations (live search)
     */
    public function search(Request $request): JsonResponse
    {
        $term = $request->get('q', '');

        if (strlen($term) < 2) {
            return response()->json(['results' => [], 'message' => 'Type at least 2 characters']);
        }

        $results = Destination::search($term)
            ->select('id', 'name', 'slug', 'country', 'city', 'category', 'image', 'rating')
            ->limit(6)
            ->get()
            ->map(fn ($d) => [
                'id'       => $d->id,
                'name'     => $d->name,
                'slug'     => $d->slug,
                'location' => "{$d->city}, {$d->country}",
                'category' => $d->category,
                'image'    => $d->image,
                'rating'   => $d->rating,
                'url'      => route('destinations.show', $d->slug),
            ]);

        return response()->json([
            'results' => $results,
            'count'   => $results->count(),
        ]);
    }

    /**
     * AJAX: Filter destinations by category (homepage cards)
     */
    public function filter(Request $request): JsonResponse
    {
        $category = $request->get('category');
        $limit    = (int) $request->get('limit', 6);

        $query = Destination::popular();
        if ($category && $category !== 'All') {
            $query->byCategory($category);
        }
        $destinations = $query->orderByDesc('rating')->limit($limit)->get();

        $cards = $destinations->map(fn ($d) => [
            'id'              => $d->id,
            'name'            => $d->name,
            'slug'            => $d->slug,
            'country'         => $d->country,
            'city'            => $d->city,
            'category'        => $d->category,
            'category_color'  => $d->category_color,
            'category_icon'   => $d->category_icon,
            'image'           => $d->image,
            'short_description'=> $d->short_description,
            'rating'          => $d->rating,
            'stars_html'      => $d->stars_html,
            'reviews_count'   => number_format($d->reviews_count),
            'url'             => route('destinations.show', $d->slug),
        ]);

        return response()->json([
            'destinations' => $cards,
            'count'        => $cards->count(),
        ]);
    }

    /**
     * AJAX: Get featured destination
     */
    public function featured(): JsonResponse
    {
        $d = Destination::featured()->orderByDesc('rating')->first();

        if (!$d) {
            return response()->json(['destination' => null]);
        }

        return response()->json([
            'destination' => [
                'id'               => $d->id,
                'name'             => $d->name,
                'country'          => $d->country,
                'city'             => $d->city,
                'category'         => $d->category,
                'image'            => $d->image,
                'description'      => $d->description,
                'short_description'=> $d->short_description,
                'rating'           => $d->rating,
                'stars_html'       => $d->stars_html,
                'reviews_count'    => number_format($d->reviews_count),
                'best_time'        => $d->best_time,
                'estimated_budget' => $d->estimated_budget,
                'highlights'       => $d->highlights,
                'url'              => route('destinations.show', $d->slug),
            ],
        ]);
    }

    /**
     * AJAX: Toggle save/unsave a destination (session-based)
     */
    public function toggleSave(Request $request, int $id): JsonResponse
    {
        $saved = session()->get('saved_destinations', []);

        if (in_array($id, $saved)) {
            $saved = array_values(array_filter($saved, fn ($s) => $s !== $id));
            $action = 'removed';
        } else {
            $saved[] = $id;
            $action  = 'saved';
        }

        session()->put('saved_destinations', $saved);

        return response()->json([
            'action' => $action,
            'saved'  => $saved,
        ]);
    }
}
