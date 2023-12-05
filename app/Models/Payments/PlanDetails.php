<?php

namespace App\Models\Payments;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'tblPlanDetails';
    protected $primaryKey = 'planId';

    // Specify the name for the created_at column
    const CREATED_AT = 'planCreatedDate';

    // Disable timestamps for this model
    public $timestamps = false;
}
