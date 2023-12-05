<?php

namespace App\Http\Controllers\LoginControllers;

use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\LoginRequests\Login;
use App\Http\Requests\LoginRequests\Register;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoginMails\LoginSuccess;
use App\Mail\LoginMails\RegisterSuccess;
use Jenssegers\Agent\Agent;
use App\Models\User\User;
use App\Models\User\UserLoginLog;

class LoginController extends BaseController
{
    public function login(Login $request)
    {
        $agent = new Agent();
        $credentials = $request->only('username', 'password');
        $userData = User::select('userId', 'userFirstName', 'userLastName', 'userEmail', 'userSecret')->where('userLogin', '=', $credentials['username'])->where('userPassword', '=', hash('sha512', $credentials['password']))->get();
        // dd($userData);
        $loginDetails = [
            'userId' => $userData[0]->userId,
            'ipAddress' => $request->ip(),
            'browserInfo' => $request->userAgent(),
            'operatingSystem' => $agent->platform(),
            'deviceType' => $agent->device(),
        ];
        $customData = [
            'date' => now()->format('j F, Y'),
            'name' => $userData[0]->userFirstName.' '.$userData[0]->userLastName,
        ];
        Mail::to($userData[0]->userEmail)->send(new LoginSuccess($customData));
        UserLoginLog::insert($loginDetails);
        echo '<pre>';
        print_r($loginDetails);
    }

    public function register(Register $request)
    {
        $data = $request->validated();
        $return = User::insertdata($data);
        $customData = [
            'date' => now()->format('j F, Y'),
            'name' => $data["firstName"].' '.$data["lastName"],
        ];
        Mail::to($data["email"])->send(new RegisterSuccess($customData));
        echo '<pre>';
        echo $return;
    }
}
