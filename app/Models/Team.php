<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, Team::class);
    }
}
