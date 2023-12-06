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
            "userRole" => isset($data["role"]) ? $data["role"] : null,
            "userCapabilities" => isset($data["capabilities"]) ? (preg_replace('/\s+/', ' ', $data["capabilities"])) : (null),
            "userSettings" => isset($data["settings"]) ? preg_replace('/\s+/', ' ', $data["settings"]) : null,
        );
        $insertedId = self::insert($details);
        return $insertedId;
    }
}
