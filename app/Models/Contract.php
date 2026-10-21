<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD

class Contract extends Model
{
    //
}
=======
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contract extends Model
{
    protected $fillable = ['quotation_id', 'customer_id', 'contract_number', 'value', 'signed_date', 'status'];

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
>>>>>>> 72f5237d663e404ee450fd532a2b229ee05201ee
