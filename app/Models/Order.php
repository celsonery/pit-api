<?php

namespace App\Models;

use App\Observers\OrderObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(OrderObserver::class)]

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'total',
        'status',
        'bgcolor'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function gtins(): BelongsToMany
    {
        return $this->belongsToMany(Gtin::class);
    }
}
