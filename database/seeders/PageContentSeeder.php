<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageContent;
use Illuminate\Support\Facades\DB;

class PageContentSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate table before seeding defaults
        DB::table('page_contents')->delete();

        $rows = [];
        $sort = 0;

        /* ===================================================
         * HOME PAGE
         * =================================================== */
        $homePage = [
            // Hero
            ['key' => 'hero_badge',             'label' => 'Hero Badge Text',              'type' => 'text',     'value' => 'Explore 500+ Destinations Worldwide'],
            ['key' => 'hero_title',             'label' => 'Hero Title (HTML allowed)',    'type' => 'text',     'value' => "Find Your Next<br><em>Dream Destination</em>"],
            ['key' => 'hero_subtitle',          'label' => 'Hero Subtitle',                'type' => 'textarea', 'value' => 'Curated travel experiences for the modern explorer. Discover breathtaking places, plan unforgettable journeys, and turn wanderlust into reality.'],
            // Popular Destinations section
            ['key' => 'dest_section_label',     'label' => 'Destinations Section Label',   'type' => 'text',     'value' => 'Popular Destinations'],
            ['key' => 'dest_section_title',     'label' => 'Destinations Section Title',   'type' => 'text',     'value' => "Handpicked for<br>Your Next Adventure"],
            ['key' => 'dest_section_subtitle',  'label' => 'Destinations Section Subtitle', 'type' => 'textarea', 'value' => "From sun-kissed beaches to towering mountain peaks — your perfect trip starts here."],
            // Categories section
            ['key' => 'cat_section_label',      'label' => 'Categories Section Label',     'type' => 'text',     'value' => 'Browse by Category'],
            ['key' => 'cat_section_title',      'label' => 'Categories Section Title',     'type' => 'text',     'value' => "What Kind of Traveler<br>Are You?"],
            // Why Roam section
            ['key' => 'whyus_section_label',    'label' => 'Why Us Section Label',         'type' => 'text',     'value' => 'Why Roam'],
            ['key' => 'whyus_section_title',    'label' => 'Why Us Section Title',         'type' => 'text',     'value' => "Your Perfect Travel<br>Companion"],
            ['key' => 'whyus_cards',            'label' => 'Why Us Cards (JSON)',           'type' => 'json',     'value' => json_encode([
                ['icon' => 'fa-map-marked-alt', 'title' => 'Curated Destinations',   'desc' => "Every destination is handpicked and verified by our team of expert travelers. No generic lists — only the best."],
                ['icon' => 'fa-route',          'title' => 'Easy Trip Planning',      'desc' => "Intuitive tools to plan your perfect itinerary in minutes. From flights to hidden gems, we've got you covered."],
                ['icon' => 'fa-lightbulb',      'title' => 'Rich Travel Inspiration', 'desc' => "Discover stunning photography, insider tips, and travel stories that spark your next adventure."],
                ['icon' => 'fa-shield-alt',     'title' => 'Trusted Recommendations', 'desc' => "Backed by thousands of verified traveler reviews, you can explore with complete confidence."],
            ])],
            // Travel Guide section
            ['key' => 'guide_section_label',    'label' => 'Travel Guide Section Label',   'type' => 'text',     'value' => 'Travel Guide'],
            ['key' => 'guide_section_title',    'label' => 'Travel Guide Section Title',   'type' => 'text',     'value' => "Stories & Tips for<br>Smart Travelers"],
            // Testimonials section
            ['key' => 'testi_section_label',    'label' => 'Testimonials Section Label',   'type' => 'text',     'value' => 'Travelers Love Roam'],
            ['key' => 'testi_section_title',    'label' => 'Testimonials Section Title',   'type' => 'text',     'value' => "Real Stories from<br>Real Explorers"],
            // Newsletter section
            ['key' => 'nl_section_label',       'label' => 'Newsletter Section Label',     'type' => 'text',     'value' => 'Stay Inspired'],
            ['key' => 'nl_title',               'label' => 'Newsletter Title',             'type' => 'text',     'value' => 'Never Miss a Hidden Gem'],
            ['key' => 'nl_subtitle',            'label' => 'Newsletter Subtitle',          'type' => 'textarea', 'value' => "Join 50,000+ travelers who get weekly destination guides, travel tips, and exclusive deals delivered straight to their inbox."],
        ];

        foreach ($homePage as $field) {
            $rows[] = array_merge(['page' => 'home', 'sort_order' => $sort++], $field, ['created_at' => now(), 'updated_at' => now()]);
        }

        /* ===================================================
         * ABOUT PAGE
         * =================================================== */
        $sort = 0;
        $aboutPage = [
            ['key' => 'hero_badge',    'label' => 'Hero Badge',         'type' => 'text',     'value' => 'Our Story'],
            ['key' => 'hero_title',    'label' => 'Hero Title',         'type' => 'text',     'value' => 'About Roam'],
            ['key' => 'hero_subtitle', 'label' => 'Hero Subtitle',      'type' => 'textarea', 'value' => "We're a team of passionate travelers who believe the world is best experienced firsthand — and we're here to make every journey unforgettable."],
            ['key' => 'mission_label', 'label' => 'Mission Label',      'type' => 'text',     'value' => 'Our Mission'],
            ['key' => 'mission_title', 'label' => 'Mission Title',      'type' => 'text',     'value' => "Inspiring a world full of <em style=\"font-style:italic;color:var(--teal)\">explorers</em>"],
            ['key' => 'mission_text',  'label' => 'Mission Paragraph 1', 'type' => 'textarea', 'value' => "Roam was born from a simple belief: that travel transforms lives. Whether it's a solo backpacking trip through Southeast Asia or a luxury getaway to the Maldives, every journey leaves a mark."],
            ['key' => 'mission_text2', 'label' => 'Mission Paragraph 2', 'type' => 'textarea', 'value' => "We hand-curate every destination on our platform — verified by our team of travel experts and backed by real traveler reviews. No sponsored fluff, just honest, beautiful places worth visiting."],
            ['key' => 'stats',         'label' => 'Stats (JSON)',        'type' => 'json',     'value' => json_encode([
                ['num' => '200+', 'label' => 'Destinations'],
                ['num' => '50K+', 'label' => 'Happy Travelers'],
                ['num' => '95%',  'label' => 'Satisfaction Rate'],
                ['num' => '40+',  'label' => 'Countries'],
            ])],
            ['key' => 'values_label',  'label' => 'Values Section Label', 'type' => 'text',     'value' => 'What We Stand For'],
            ['key' => 'values_title',  'label' => 'Values Section Title', 'type' => 'text',     'value' => 'Our Core Values'],
            ['key' => 'values',        'label' => 'Core Values (JSON)',  'type' => 'json',     'value' => json_encode([
                ['icon' => 'fa-heart',          'title' => 'Passion First',        'desc' => "We only feature destinations we're truly excited about — places our team has researched deeply and would visit themselves."],
                ['icon' => 'fa-shield-alt',     'title' => 'Honest Curation',      'desc' => "No pay-to-feature. Every destination is chosen for its beauty, uniqueness, and traveler value."],
                ['icon' => 'fa-leaf',           'title' => 'Sustainable Travel',   'desc' => "We promote responsible tourism and highlight eco-friendly options to protect the places we love."],
                ['icon' => 'fa-users',          'title' => 'Community Driven',     'desc' => "Real reviews from real travelers drive our rankings and help us discover hidden gems worldwide."],
                ['icon' => 'fa-globe',          'title' => 'For Every Traveler',   'desc' => "From budget backpackers to luxury seekers — we have something for every travel style and budget."],
                ['icon' => 'fa-map-marked-alt', 'title' => 'Deep Local Knowledge', 'desc' => "Our guides go beyond the tourist trails to uncover authentic local experiences you won't find elsewhere."],
            ])],
            ['key' => 'team_label',    'label' => 'Team Section Label', 'type' => 'text',     'value' => 'The People Behind Roam'],
            ['key' => 'team_title',    'label' => 'Team Section Title', 'type' => 'text',     'value' => 'Meet Our Team'],
            ['key' => 'team_subtitle', 'label' => 'Team Subtitle',      'type' => 'textarea', 'value' => 'Explorers, writers, designers, and tech enthusiasts united by a love for travel.'],
            ['key' => 'team',          'label' => 'Team Members (JSON)', 'type' => 'json',     'value' => json_encode([
                ['name' => 'Alex Rivera',   'role' => 'Founder & CEO',      'img' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&q=80', 'bio' => 'Traveled to 80+ countries. Believes every trip changes you forever.'],
                ['name' => 'Sasha Kim',     'role' => 'Head of Curation',   'img' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300&q=80', 'bio' => 'Spent 3 years nomadic before joining Roam. Obsessed with hidden beaches.'],
                ['name' => 'Marco Delgado', 'role' => 'Lead Designer',      'img' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&q=80', 'bio' => 'Converts wanderlust into beautiful pixels. Coffee-fueled adventurer.'],
                ['name' => 'Nadia Hassan',  'role' => 'Community Manager',  'img' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=300&q=80', 'bio' => 'Built our traveler community from 0 to 50K. Fluent in 4 languages.'],
            ])],
            ['key' => 'cta_label',    'label' => 'CTA Label',           'type' => 'text',     'value' => 'Ready?'],
            ['key' => 'cta_title',    'label' => 'CTA Title',           'type' => 'text',     'value' => 'Start Exploring Today'],
            ['key' => 'cta_subtitle', 'label' => 'CTA Subtitle',        'type' => 'textarea', 'value' => "Join thousands of travelers discovering the world's most breathtaking destinations with Roam."],
        ];

        foreach ($aboutPage as $field) {
            $rows[] = array_merge(['page' => 'about', 'sort_order' => $sort++], $field, ['created_at' => now(), 'updated_at' => now()]);
        }

        /* ===================================================
         * GUIDE PAGE
         * =================================================== */
        $sort = 0;
        $guidePage = [
            ['key' => 'hero_badge',    'label' => 'Hero Badge',      'type' => 'text',     'value' => 'Plan Smarter'],
            ['key' => 'hero_title',    'label' => 'Hero Title',      'type' => 'text',     'value' => 'Travel Guide'],
            ['key' => 'hero_subtitle', 'label' => 'Hero Subtitle',   'type' => 'textarea', 'value' => 'Everything you need before, during, and after your trip — expertly compiled by our team of seasoned travelers.'],
            ['key' => 'guides_label',  'label' => 'Guides Section Label', 'type' => 'text', 'value' => 'Essential Guides'],
            ['key' => 'guides_title',  'label' => 'Guides Section Title', 'type' => 'text', 'value' => 'Your Complete Travel Toolkit'],
            ['key' => 'guide_cards',   'label' => 'Guide Cards (JSON)',   'type' => 'json', 'value' => json_encode([
                ['id' => 'before-you-go',    'icon' => 'fa-clipboard-check', 'color_bg' => 'rgba(13,124,120,.1)',  'color' => 'var(--teal)',  'title' => 'Before You Go',   'tag' => 'Pre-Trip Checklist',      'steps' => ["<strong>Check passport validity</strong> — most countries require 6+ months validity", "<strong>Research visa requirements</strong> for your destination", "<strong>Book accommodation</strong> in advance for peak seasons", "<strong>Get travel insurance</strong> — always worth it", "<strong>Set up international banking</strong> or get a travel card", "<strong>Download offline maps</strong> and translation apps"]],
                ['id' => 'packing-lists',    'icon' => 'fa-suitcase-rolling', 'color_bg' => 'rgba(232,113,74,.1)', 'color' => 'var(--coral)', 'title' => 'Packing Smart',   'tag' => 'What to Bring',           'steps' => ["<strong>Roll, don't fold</strong> clothes to save 30% more space", "<strong>Pack a power bank</strong> — lifesaver for long travel days", "<strong>One week of clothes</strong> — laundry facilities exist everywhere", "<strong>Compression bags</strong> for bulky items", "<strong>Versatile shoes</strong> — one pair for walking, one smart", "<strong>First-aid kit</strong> with essentials and prescriptions"]],
                ['id' => 'budgeting',        'icon' => 'fa-wallet',          'color_bg' => 'rgba(91,196,212,.15)', 'color' => 'var(--sky)',   'title' => 'Budgeting',       'tag' => 'Travel on Any Budget',    'steps' => ["<strong>Book flights 6–8 weeks ahead</strong> for best prices", "<strong>Use incognito mode</strong> when searching for flights", "<strong>Eat where locals eat</strong> — cheaper and more authentic", "<strong>Free walking tours</strong> beat paid group tours most times", "<strong>Track every expense</strong> daily with a travel budgeting app", "<strong>Set a daily limit</strong> and stick to it — give yourself 10% flex"]],
                ['id' => 'safety-tips',      'icon' => 'fa-shield-alt',      'color_bg' => 'rgba(239,68,68,.1)',  'color' => '#EF4444',      'title' => 'Safety Tips',     'tag' => 'Stay Safe Abroad',        'steps' => ["<strong>Keep digital copies</strong> of all documents in cloud storage", "<strong>Share your itinerary</strong> with a trusted contact back home", "<strong>Use hotel safes</strong> for passports and valuables", "<strong>Avoid flashy jewelry</strong> in crowded tourist areas", "<strong>Know the emergency numbers</strong> of your destination", "<strong>Trust your instincts</strong> — leave if something feels wrong"]],
                ['id' => 'local-etiquette',  'icon' => 'fa-hands',           'color_bg' => 'rgba(167,139,250,.15)', 'color' => '#7C3AED',     'title' => 'Local Etiquette', 'tag' => 'Respect & Culture',       'steps' => ["<strong>Learn basic phrases</strong> — \"hello\" and \"thank you\" go a long way", "<strong>Dress modestly</strong> when visiting temples and religious sites", "<strong>Ask permission</strong> before photographing people", "<strong>Study tipping customs</strong> — they vary widely by country", "<strong>Be punctual</strong> in some cultures, relaxed in others", "<strong>Try local food</strong> — refusing can sometimes be impolite"]],
                ['id' => 'booking-hacks',    'icon' => 'fa-percentage',      'color_bg' => 'rgba(16,185,129,.1)', 'color' => '#059669',      'title' => 'Booking Hacks',   'tag' => 'Save More Money',         'steps' => ["<strong>Fly midweek</strong> (Tue/Wed) for up to 20% cheaper flights", "<strong>Use VPN</strong> to see prices from different countries", "<strong>Book directly with hotels</strong> for better cancellation terms", "<strong>Sign up for price alerts</strong> on Google Flights and Skyscanner", "<strong>Package deals</strong> often beat booking separately", "<strong>Last-minute apps</strong> like HotelTonight for spontaneous trips"]],
            ])],
            ['key' => 'pro_tip_label',  'label' => 'Pro Tip Label',    'type' => 'text',     'value' => 'Pro Tip'],
            ['key' => 'pro_tip_title',  'label' => 'Pro Tip Title',    'type' => 'text',     'value' => 'The best travel hack? Embrace the unexpected.'],
            ['key' => 'pro_tip_text',   'label' => 'Pro Tip Text',     'type' => 'textarea', 'value' => "Over-planning kills spontaneity. Leave at least 30% of your itinerary open for detours, local recommendations, and happy accidents. The best travel memories often come from unplanned moments."],
        ];

        foreach ($guidePage as $field) {
            $rows[] = array_merge(['page' => 'guide', 'sort_order' => $sort++], $field, ['created_at' => now(), 'updated_at' => now()]);
        }

        /* ===================================================
         * CONTACT PAGE
         * =================================================== */
        $sort = 0;
        $contactPage = [
            ['key' => 'hero_badge',     'label' => 'Hero Badge',           'type' => 'text',     'value' => 'Say Hello'],
            ['key' => 'hero_title',     'label' => 'Hero Title',           'type' => 'text',     'value' => 'Contact Us'],
            ['key' => 'hero_subtitle',  'label' => 'Hero Subtitle',        'type' => 'textarea', 'value' => "Questions, suggestions, or just want to share a travel story? We'd love to hear from you."],
            ['key' => 'form_title',     'label' => 'Form Card Title',      'type' => 'text',     'value' => "We'll reply within 24 hours"],
            ['key' => 'form_subtitle',  'label' => 'Form Card Subtitle',   'type' => 'textarea', 'value' => 'Fill in the form below and a member of our team will get back to you shortly.'],
            ['key' => 'info_label',     'label' => 'Info Card Label',      'type' => 'text',     'value' => 'Get in Touch'],
            ['key' => 'email',          'label' => 'Email Address',        'type' => 'text',     'value' => 'hello@roamtravel.com'],
            ['key' => 'phone',          'label' => 'Phone Number',         'type' => 'text',     'value' => '+1 (555) 012–3456'],
            ['key' => 'office',         'label' => 'Office Location',      'type' => 'text',     'value' => 'San Francisco, CA, USA'],
            ['key' => 'hours',          'label' => 'Business Hours',       'type' => 'text',     'value' => 'Mon – Fri, 9am – 6pm PST'],
            ['key' => 'social_label',   'label' => 'Social Media Label',   'type' => 'text',     'value' => 'Social Media'],
            ['key' => 'social_subtitle', 'label' => 'Social Media Subtitle', 'type' => 'textarea', 'value' => 'Follow us for daily travel inspiration, destination spotlights, and behind-the-scenes content.'],
            ['key' => 'social_links',   'label' => 'Social Links (JSON)',  'type' => 'json',     'value' => json_encode([
                ['icon' => 'fa-instagram',  'name' => 'Instagram', 'url' => '#'],
                ['icon' => 'fa-twitter',    'name' => 'Twitter',   'url' => '#'],
                ['icon' => 'fa-facebook-f', 'name' => 'Facebook',  'url' => '#'],
                ['icon' => 'fa-pinterest-p', 'name' => 'Pinterest', 'url' => '#'],
            ])],
        ];

        foreach ($contactPage as $field) {
            $rows[] = array_merge(['page' => 'contact', 'sort_order' => $sort++], $field, ['created_at' => now(), 'updated_at' => now()]);
        }

        /* ===================================================
         * BLOG PAGE
         * =================================================== */
        $sort = 0;
        $blogPage = [
            ['key' => 'hero_badge',    'label' => 'Hero Badge',    'type' => 'text',     'value' => 'Our Journal'],
            ['key' => 'hero_title',    'label' => 'Hero Title',    'type' => 'text',     'value' => 'Travel Stories & Guides'],
            ['key' => 'hero_subtitle', 'label' => 'Hero Subtitle', 'type' => 'textarea', 'value' => 'Inspiration, tips, and insider knowledge from our team of globe-trotters.'],
        ];

        foreach ($blogPage as $field) {
            $rows[] = array_merge(['page' => 'blog', 'sort_order' => $sort++], $field, ['created_at' => now(), 'updated_at' => now()]);
        }

        DB::table('page_contents')->insert($rows);
    }
}
