<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Screening extends Model
{
    use HasFactory;

    protected $fillable = ['movie_id', 'screen', 'total_seats', 'date_and_time'];

    protected $with = ['movie'];

    protected $withCount = ['bookings'];

    protected $appends = ['seats_taken', 'seats_left'];

    protected $casts = [
        'date_and_time' => 'datetime',
    ];

    /**
     * Get the movie for the screening.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id', 'id');
    }

    /**
     * Get all of the bookings for the Screening
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    protected function getSeatsTakenAttribute()
    {
        return $this->bookings_count;
    }

    protected function getSeatsLeftAttribute()
    {
        return $this->total_seats - $this->bookings_count;
    }
}
