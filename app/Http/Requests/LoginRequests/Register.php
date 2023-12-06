<?php

namespace App\Http\Requests\LoginRequests;

use Illuminate\Foundation\Http\FormRequest;

class Register extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust as needed based on your authorization logic
    }

    public function rules()
    {
        return [
            "firstName" => "required|string",
            "lastName" => "required|string",
            "email" => "required|email",
            "contactNumber" => ["required", "regex:/^[0-9]{10}$/"],
            "login" => "required|string",
            "password" => "required|string",
            "role" => "string",
            "capabilities" => "string",
            "settings" => "string",
        ];
    }
}
