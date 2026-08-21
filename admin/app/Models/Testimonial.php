<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'quote_en',
        'quote_mm',
        'name',
        'role_en',
        'role_mm',
        'avatar',
        'rating',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'rating' => 'integer',
        ];
    }
}
