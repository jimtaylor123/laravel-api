<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'author_id',
        'commentable_id',
        'commentable_type'
    ];
    
    public function owner(): BelongsTo
    {
        return $this->belongsTo (User::class, 'owner_id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo (Project::class);
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
