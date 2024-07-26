<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    // Specify the table name if not following Laravel's convention
    protected $table = 'cars';

    // Define which attributes are mass assignable
    protected $fillable = [
        'friend_name',
        'car_type',
        'car_cost',
        'date_bought',
    ];
}