<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'prep_time',
        'difficulty',
        'image',
    ];

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

}
