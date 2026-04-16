<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'product_id', 'customer_name', 'customer_phone',
        'customer_email', 'message', 'whatsapp_sent_at', 'status',
    ];

    protected function casts(): array
    {
        return [
            'whatsapp_sent_at' => 'datetime',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
