<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

class Auth
{
    public static function check(Request $request) {
        return true;
    }
}
