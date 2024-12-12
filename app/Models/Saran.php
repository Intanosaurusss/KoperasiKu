<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Saran extends Model
{
    use HasFactory;

    /**
     * Table associated with the model.
     */
    protected $table = 'saran';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'rating',
        'saran',
    ];

    /**
     * Define the relationship with the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
