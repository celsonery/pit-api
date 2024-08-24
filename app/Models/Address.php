<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cep',
        'address',
        'number',
        'complement',
        'neighborhood',
        'province',
        'reference',
        'main',
        'nickname'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
