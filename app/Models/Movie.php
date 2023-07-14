<?php

namespace App\Models;

use App\Models\Screening;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movie extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['title', 'duration', 'genre', 'description', 'rating'];

    /**
     * Get the screenings for the movie.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function screenings()
    {
        return $this->hasMany(Screening::class);
    }
}
