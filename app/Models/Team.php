<?php

namespace App\Models;

use App\Models\User;
use App\Models\Account;
use App\Traits\HasType;
use App\Traits\HasAllowedAttributes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory, HasAllowedAttributes, HasType; 

    protected $fillable = [
        'name',
        'account_id'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
