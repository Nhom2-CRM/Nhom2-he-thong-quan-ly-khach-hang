<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> feature/S6-06-activity-backend

class Quotation extends Model
{
    //
}
<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quotation extends Model
{
    protected $fillable = ['opportunity_id', 'customer_id', 'code', 'total_amount', 'status'];

    public function opportunity(): BelongsTo
    {
        return $this->belongsTo(Opportunity::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
>>>>>>> 72f5237d663e404ee450fd532a2b229ee05201ee
=======
>>>>>>> feature/S6-06-activity-backend
