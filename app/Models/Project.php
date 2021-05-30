<?php

namespace App\Models;

use App\Models\User;
use App\Models\Account;
use App\Models\Comment;
use App\Traits\HasType;
use App\Traits\HasAllowedAttributes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory, HasAllowedAttributes, HasType; 

    protected $fillable = [
        'name',
        'owner_id',
        'account_id',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo (User::class, 'owner_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
