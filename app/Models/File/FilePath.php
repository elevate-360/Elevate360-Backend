<?php

namespace App\Models\Files;

use Illuminate\Database\Eloquent\Model;

class FilePath extends Model
{
    protected $table = 'tblFilesUploadPath';
    protected $primaryKey = 'pathId';

    // Specify the name for the created_at column
    const CREATED_AT = 'createdOn';

    // Specify the name for the updated_at column
    const UPDATED_AT = 'modifiedOn';
}
