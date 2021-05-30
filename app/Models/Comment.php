<?php

namespace App\Models;

use App\Models\User;
use App\Models\Project;
use App\Traits\HasType;
use App\Traits\HasAllowedAttributes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory, HasAllowedAttributes, HasType; 

    protected $fillable = [
        'text',
        'author_id',
        'commentable_id',
        'commentable_type'
    ];
    
    public function author(): BelongsTo
    {
        return $this->belongsTo (User::class, 'author_id');
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
