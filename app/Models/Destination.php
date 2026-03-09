<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'country', 'city', 'category', 'image', 'gallery',
        'description', 'short_description', 'highlights', 'activities',
        'best_time', 'estimated_budget', 'rating', 'reviews_count',
        'is_featured', 'is_popular', 'latitude', 'longitude',
    ];

    protected $casts = [
        'gallery'     => 'array',
        'highlights'  => 'array',
        'activities'  => 'array',
        'is_featured' => 'boolean',
        'is_popular'  => 'boolean',
        'rating'      => 'float',
    ];

    // ── Scopes ──────────────────────────────────────────────────
    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $category ? $query->where('category', $category) : $query;
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name',     'like', "%{$term}%")
              ->orWhere('country', 'like', "%{$term}%")
              ->orWhere('city',    'like', "%{$term}%")
              ->orWhere('category','like', "%{$term}%");
        });
    }

    // ── Accessors ───────────────────────────────────────────────
    public function getCategoryColorAttribute(): string
    {
        return match ($this->category) {
            'Beach'     => 'primary',
            'Mountain'  => 'success',
            'City'      => 'warning',
            'Nature'    => 'info',
            'Cultural'  => 'secondary',
            'Adventure' => 'danger',
            default     => 'secondary',
        };
    }

    public function getCategoryIconAttribute(): string
    {
        return match ($this->category) {
            'Beach'     => 'fa-umbrella-beach',
            'Mountain'  => 'fa-mountain',
            'City'      => 'fa-city',
            'Nature'    => 'fa-leaf',
            'Cultural'  => 'fa-landmark',
            'Adventure' => 'fa-person-hiking',
            default     => 'fa-map-pin',
        };
    }

    public function getStarsHtmlAttribute(): string
    {
        $full  = (int) floor($this->rating);
        $half  = ($this->rating - $full) >= 0.5 ? 1 : 0;
        $empty = 5 - $full - $half;
        $html  = '';
        for ($i = 0; $i < $full;  $i++) $html .= '<i class="fas fa-star text-warning"></i>';
        if ($half)                       $html .= '<i class="fas fa-star-half-alt text-warning"></i>';
        for ($i = 0; $i < $empty; $i++) $html .= '<i class="far fa-star text-warning"></i>';
        return $html;
    }
}
