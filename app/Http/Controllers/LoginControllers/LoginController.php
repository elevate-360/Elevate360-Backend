<?php

namespace App\Http\Controllers\LoginControllers;

use Illuminate\Routing\Controller as BaseController;
use App\Http\Requests\LoginRequests\Login;
use App\Http\Requests\LoginRequests\Register;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\LoginMails\LoginSuccess;
use App\Mail\LoginMails\RegisterSuccess;
use Jenssegers\Agent\Agent;
use App\Models\User\User;
use App\Models\User\UserLoginLog;
use Exception;
use Illuminate\Support\Facades\DB;

class LoginController extends BaseController
{
    public function login(Login $request)
    {
        $agent = new Agent();
        $credentials = $request->only('username', 'password');
        $userData = User::select('userId', 'userFirstName', 'userLastName', 'userEmail', 'userSecret', "userPassword")->where('userLogin', '=', $credentials['username'])->get();
        if (isset($userData[0])) {
            if ($userData[0]->userPassword == hash('sha512', $credentials['password'])) {
                $loginDetails = [
                    'userId' => $userData[0]->userId,
                    'ipAddress' => $request->ip(),
                    'browserInfo' => $request->userAgent(),
                    'operatingSystem' => $agent->platform(),
                    'deviceType' => $agent->device(),
                    'loginTime' => date("H:m:i"),
                    'loginDate' => date("Y-m-d")
                ];
                $customData = [
                    'date' => now()->format('j F, Y'),
                    'name' => $userData[0]->userFirstName . ' ' . $userData[0]->userLastName,
                ];
                try {
                    // Mail::to($userData[0]->userEmail)->send(new LoginSuccess($customData));
                } catch (Exception $e) {
                    Log::error('Login Mail Error For User ' . $credentials["username"] . ': ' . $e->getMessage());
                }
                UserLoginLog::upsert(
                    $loginDetails,
                    ['userId', 'loginDate'],
                    ['loginCount' => DB::raw('loginCount + 1')]
                );
                $userReturn = array(
                    "userFirstName" => $userData[0]->userFirstName,
                    "userLastName" => $userData[0]->userLastName,
                    "userEmail" => $userData[0]->userEmail,
                    "accessToken" => $userData[0]->userSecret
                );
                return json_encode($userReturn);
            } else {
                return json_encode(array("message" => "Incorrect Password!!!", "type" => "error"));
            }
        } else {
            return json_encode(array("message" => "User Not Found!!!", "type" => "error"));
        }
    }

    public function register(Register $request)
    {
        $data = $request->validated();
        $return = User::insertdata($data);
        $customData = [
            'date' => now()->format('j F, Y'),
            'name' => $data["firstname"] . ' ' . $data["lastname"],
        ];
        try {
            Mail::to($data["email"])->send(new RegisterSuccess($customData));
        } catch (Exception $e) {
            Log::error('Register Mail Error For User ' . $data["login"] . ': ' . $e->getMessage());
        }
        return json_encode($return);
    }
}
