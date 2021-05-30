<?php

namespace App\Models;

use App\Models\Team;
use App\Models\User;
use App\Models\Project;
use App\Traits\HasType;
use App\Models\AccountType;
use Laravel\Cashier\Billable;
use App\Traits\HasAllowedAttributes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory, Billable, HasFactory, HasAllowedAttributes, HasType; 

    protected $fillable = [
        'name',
        'owner_id',
        'account_type_id',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo (User::class, 'owner_id');
    }

    public function accountType(): BelongsTo
    {
        return $this->belongsTo (AccountType::class, 'account_type_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
