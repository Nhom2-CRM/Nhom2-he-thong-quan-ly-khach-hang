<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'amount',
        'customer_id',
        'user_id',
        'sales_team_id',
        'stage_id',
        'snapshot_win_probability',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function salesTeam()
    {
        return $this->belongsTo(SalesTeam::class);
    }

    public function stage()
    {
        return $this->belongsTo(PipelineStage::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}