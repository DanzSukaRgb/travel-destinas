<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Destination::query()->exists() || $this->call(DestinationSeeder::class);

        // Seed page CMS content (only if table is empty)
        if (\App\Models\PageContent::count() === 0) {
            $this->call(PageContentSeeder::class);
        }

        // Regular test user
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name'     => 'Test User',
                'is_admin' => false,
                'password' => bcrypt('password'),
            ]
        );

        // Admin user  →  login: admin@roam.com / password: admin123
        User::firstOrCreate(
            ['email' => 'admin@roam.com'],
            [
                'name'     => 'Roam Admin',
                'is_admin' => true,
                'password' => bcrypt('admin123'),
            ]
        );
    }
}
