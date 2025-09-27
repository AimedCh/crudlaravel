<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alquileres extends Model
{
    use HasFactory;

    protected $table = 'alquileres';

    protected $fillable = [
        'title',
        'description',
        'address',
        'city',
        'price_per_night',
        'max_guests',
        'bedrooms',
        'bathrooms',
        'amenities',
        'image',
        'rating',
        'is_active',
        'available',
        'distance_to_beach',
        'latitude',
        'longitude'
    ];

    protected $casts = [
        'amenities' => 'array',
        'price_per_night' => 'decimal:2',
        'rating' => 'decimal:2',
        'distance_to_beach' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_active' => 'boolean',
        'available' => 'boolean',
        'max_guests' => 'integer',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer'
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('available', true);
    }

    public function scopeByCity($query, $city)
    {
        return $query->where('city', $city);
    }

    public function scopeByPriceRange($query, $min, $max)
    {
        return $query->whereBetween('price_per_night', [$min, $max]);
    }
}