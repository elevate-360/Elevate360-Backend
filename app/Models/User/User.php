<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'tblUser';
    protected $primaryKey = 'userId';

    // Specify the name for the created_at column
    const CREATED_AT = 'userCreatedDate';

    // Disable timestamps for this model
    public $timestamps = false;

    public static function insertData($data)
    {
        $details = array(
            "userFirstName" => $data["firstName"],
            "userLastName" => $data["lastName"],
            "userEmail" => $data["email"],
            "userContactNumber" => $data["contactNumber"],
            "userLogin" => $data["login"],
            "userPassword" => hash('sha512', $data["password"]),
            "userSecret" => hash('sha512', ($data["email"] . $data["login"] . $data["password"])),
            "userRole" => $data["role"],
            "userCapabilities" => preg_replace('/\s+/', ' ', $data["capabilities"]),
            "userSettings" => preg_replace('/\s+/', ' ', $data["settings"]),
        );
        $insertedId = self::insert($details);
        return $insertedId;
    }
}
