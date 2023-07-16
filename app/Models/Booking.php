<?php

namespace App\Models;

use App\Models\User;
use App\Models\Screening;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'screening_id'];

    protected $with = ['user', 'screening'];

    public static function booted()
    {
        static::addGlobalScope('FilterData', function($model){
            if(Auth::check()){
                return Auth::user()->role === 'ADMIN' ?
                    $model :
                    $model->where('user_id', Auth::id());
            }
            return $model;
        });
    }

    /**
     * Get the user for the screening.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the screening for the screening.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function screening()
    {
        return $this->belongsTo(Screening::class, 'screening_id', 'id');
    }
}
