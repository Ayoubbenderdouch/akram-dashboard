<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_surname',
        'customer_phone',
        'customer_email',
        'product_name',
        'quantity',
        'product_description',
        'product_image',
        'product_url',
        'destination_country',
        'delivery_city',
        'delivery_address',
        'shipping_method',
        'payment_method',
        'payment_currency',
        'status',
        'estimated_price',
        'admin_notes'
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    protected $casts = [
        'estimated_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
