<?php

namespace App\Models;

use Laravel\Cashier\Billable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory, Billable;

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
}
