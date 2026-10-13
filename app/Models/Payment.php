<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'external_id', 'xendit_id', 'name', 'email', 'amount',
        'description', 'status', 'invoice_url', 'paid_at',
    ];

    protected $casts = ['paid_at' => 'datetime'];
}
