<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    /**
     * Allow mass assignment for category fields
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get all events that belong to this category
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Get all speakers that belong to this category
     */
    public function speakers(): HasMany
    {
        return $this->hasMany(Speaker::class);
    }
}