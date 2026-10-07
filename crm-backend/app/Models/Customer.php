<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'user_id',
        'sales_team_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function salesTeam()
    {
        return $this->belongsTo(SalesTeam::class);
    }
}