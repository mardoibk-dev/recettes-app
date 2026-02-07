<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'recipe_id'];

    public function favoritedBy()
    {
        return $this->belongsToMany(
            \App\Models\User::class,
            'favorites'
        )->withTimestamps();
    }

}
