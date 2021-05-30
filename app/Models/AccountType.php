<?php

namespace App\Models;

use App\Models\Account;
use App\Traits\HasType;
use App\Traits\HasAllowedAttributes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class AccountType extends Model
{
    use HasFactory, HasAllowedAttributes, HasType; 

    protected $fillable = [
        'name',
    ];

   public function accounts(): HasMany
   {
       return $this->hasMany(Account::class);
   }
}
