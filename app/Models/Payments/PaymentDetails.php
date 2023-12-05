<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'tblPaymentDetails';
    protected $primaryKey = 'paymentId';

    // Specify the name for the created_at column
    const CREATED_AT = 'transactionDateTime';

    // Disable timestamps for this model
    public $timestamps = false;
}
