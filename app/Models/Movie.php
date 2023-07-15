<?php

namespace App\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'duration', 'genre', 'description', 'rating'];

    protected $appends = ['duration_in_hours'];

    /**
     * Get the screenings for the movie.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function screenings()
    {
        return $this->hasMany(Screening::class);
    }

    protected function getDurationInHoursAttribute()
    {
        return (float) number_format(CarbonInterval::minutes($this->duration)->totalHours, 2);
    }
}
