<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bio',
        'image_url',
        'price',
        'min_quantity',
        'stock',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    protected $appends = ['full_image_url'];

    public function getFullImageUrlAttribute()
    {
        if (!$this->image_url) {
            return null;
        }

        // If already absolute URL, return as is
        if (str_starts_with($this->image_url, 'http')) {
            return $this->image_url;
        }

        // Return absolute URL
        return config('app.url') . $this->image_url;
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
