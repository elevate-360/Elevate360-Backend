<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserUpdateLog extends Model
{
    protected $table = 'tblUserUpdateLog';
    protected $primaryKey = 'logId';

    // Specify the name for the created_at column
    const CREATED_AT = 'updateTime';

    // Disable timestamps for this model
    public $timestamps = false;
}
