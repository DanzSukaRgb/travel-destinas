<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $popularDestinations = Destination::popular()
            ->orderByDesc('rating')
            ->limit(6)
            ->get();

        $featuredDestination = Destination::featured()
            ->orderByDesc('rating')
            ->first();

        $categories = [
            ['name' => 'Beach',     'icon' => 'fa-umbrella-beach', 'color' => '#0D7C78', 'count' => Destination::where('category','Beach')->count()],
            ['name' => 'Mountain',  'icon' => 'fa-mountain',        'color' => '#2E7D32', 'count' => Destination::where('category','Mountain')->count()],
            ['name' => 'City',      'icon' => 'fa-city',            'color' => '#E65100', 'count' => Destination::where('category','City')->count()],
            ['name' => 'Nature',    'icon' => 'fa-leaf',            'color' => '#33691E', 'count' => Destination::where('category','Nature')->count()],
            ['name' => 'Cultural',  'icon' => 'fa-landmark',        'color' => '#4527A0', 'count' => Destination::where('category','Cultural')->count()],
            ['name' => 'Adventure', 'icon' => 'fa-person-hiking',   'color' => '#BF360C', 'count' => Destination::where('category','Adventure')->count()],
        ];

        $travelGuides = [
            [
                'title'    => 'Best Beaches for Summer 2025',
                'excerpt'  => 'Discover the world\'s most stunning beach destinations perfect for your summer escape.',
                'category' => 'Beach',
                'image'    => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=600&q=80',
                'read_time'=> '5 min read',
                'date'     => 'Jun 12, 2025',
            ],
            [
                'title'    => '7 Hidden Gems in Southeast Asia',
                'excerpt'  => 'Beyond the tourist trail — secret spots that will take your breath away.',
                'category' => 'Adventure',
                'image'    => 'https://images.unsplash.com/photo-1528181304800-259b08848526?w=600&q=80',
                'read_time'=> '7 min read',
                'date'     => 'May 28, 2025',
            ],
            [
                'title'    => 'Budget-Friendly City Escapes in Europe',
                'excerpt'  => 'Amazing city breaks that won\'t break the bank — with insider tips.',
                'category' => 'City',
                'image'    => 'https://images.unsplash.com/photo-1467269204594-9661b134dd2b?w=600&q=80',
                'read_time'=> '6 min read',
                'date'     => 'May 10, 2025',
            ],
        ];

        $testimonials = [
            ['name' => 'Sarah Johnson',   'country' => '🇺🇸 United States', 'avatar' => 'https://i.pravatar.cc/80?img=47', 'rating' => 5, 'text' => 'Roam completely changed how I plan my trips. Found an incredible hidden beach in Thailand I never would have discovered on my own!'],
            ['name' => 'Liam van der Berg','country'=> '🇳🇱 Netherlands',    'avatar' => 'https://i.pravatar.cc/80?img=12', 'rating' => 5, 'text' => 'The destination guides are incredibly detailed. Planned our entire Bali honeymoon through Roam — it was absolutely perfect.'],
            ['name' => 'Yuki Tanaka',      'country'=> '🇯🇵 Japan',           'avatar' => 'https://i.pravatar.cc/80?img=23', 'rating' => 5, 'text' => 'As a solo traveler, I love how easy it is to filter by category and find safe, beautiful places. Highly recommend!'],
        ];

        $stats = [
            'destinations' => Destination::count(),
            'cities'       => Destination::distinct('city')->count(),
            'travelers'    => 50000,
        ];

        return view('home.index', compact(
            'popularDestinations',
            'featuredDestination',
            'categories',
            'travelGuides',
            'testimonials',
            'stats'
        ));
    }
}
