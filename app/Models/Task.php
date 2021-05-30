<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use App\Models\Project;
use App\Traits\HasType;
use App\Traits\HasAllowedAttributes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory, HasAllowedAttributes, HasType; 

    protected $fillable = [
        'title',
        'description',
        'project_id',
        'owner_id',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo (User::class, 'owner_id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo (Project::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
