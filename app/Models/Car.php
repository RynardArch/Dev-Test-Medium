<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    // Define the table if it’s not following Laravel’s convention
    protected $table = 'cars';

    // Define the fillable fields
    protected $fillable = [
        'friend_name',
        'car_type',
        'car_cost',
        'date_bought',
    ];
}