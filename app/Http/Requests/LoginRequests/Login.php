<?php

namespace App\Http\Requests\LoginRequests;

use Illuminate\Foundation\Http\FormRequest;

class Login extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust as needed based on your authorization logic
    }

    public function rules()
    {
        return [
            "login" => "required|string",
            "password" => "required|string",
        ];
    }
}
