<?php

namespace App\Models;

use App\Models\Movie;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Screening extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['screen', 'seats_available', 'date_and_time'];

    /**
     * Get the movie for the screening.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * Get the searchable attributes for the screening.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'title' => $this->movie->title,
            'genre' => $this->movie->genre,
        ];
    }

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'screenings_index';
    }
}
