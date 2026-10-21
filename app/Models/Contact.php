<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD

class Contact extends Model
{
    //
}
=======
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    protected $fillable = ['customer_id', 'name', 'email', 'phone', 'position'];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
>>>>>>> 72f5237d663e404ee450fd532a2b229ee05201ee
