<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserLoginLog extends Model
{
    protected $table = 'tblUserLoginLog';
    protected $primaryKey = 'logId';
    
    // Specify the name for the created_at column
    const CREATED_AT = 'loginTime';
    
    // Disable timestamps for this model
    public $timestamps = false;
}
