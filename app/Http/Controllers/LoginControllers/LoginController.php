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
    // Login Method
    public function login(Login $request)
    {
        // Get Request Data
        $credentials = $request->only('username', 'password');

        // Fetch user Details From Database
        $userData = User::select('userId', 'userFirstName', 'userLastName', 'userEmail', 'userSecret', "userPassword")->where('userLogin', '=', $credentials['username'])->get();

        // Check User Exist or Not
        if (isset($userData[0])) {
            // Check Password
            if ($userData[0]->userPassword == hash('sha512', $credentials['password'])) {
                // Obj for getting request source details
                $agent = new Agent();

                try {
                    // Mail Details
                    $customData = [
                        'date' => now()->format('j F, Y'),
                        'name' => $userData[0]->userFirstName . ' ' . $userData[0]->userLastName,
                    ];

                    // Send Mail
                    // Mail::to($userData[0]->userEmail)->send(new LoginSuccess($customData));
                } catch (Exception $e) {
                    // Mail Error Log
                    Log::error('Login Mail Error For User ' . $credentials["username"] . ': ' . $e->getMessage());
                }

                // Login Details
                $loginDetails = [
                    'userId' => $userData[0]->userId,
                    'ipAddress' => $request->ip(),
                    'browserInfo' => $request->userAgent(),
                    'operatingSystem' => $agent->platform(),
                    'deviceType' => $agent->device(),
                    'loginTime' => date("H:m:i"),
                    'loginDate' => date("Y-m-d")
                ];

                // Insert LoginDetails in Database
                UserLoginLog::upsert(
                    $loginDetails,
                    ['userId', 'loginDate'],
                    ['loginCount' => DB::raw('loginCount + 1')]
                );

                // Create Return Data
                $userReturn = array(
                    "userFirstName" => $userData[0]->userFirstName,
                    "userLastName" => $userData[0]->userLastName,
                    "userEmail" => $userData[0]->userEmail,
                    "accessToken" => $userData[0]->userSecret
                );

                // Return Data
                return json_encode($userReturn);
            } else {
                // Invalid Password Error
                return json_encode(array("message" => "Incorrect Password!!!", "type" => "error"));
            }
        } else {
            // User Not Found Error
            return json_encode(array("message" => "User Not Found!!!", "type" => "error"));
        }
    }

    // Registration Method
    public function register(Register $request)
    {
        // Get Request Data
        $data = $request->validated();

        // Insert Data into Database
        $return = User::insertdata($data);

        try {
            // Mail Details
            $customData = [
                'date' => now()->format('j F, Y'),
                'name' => $data["firstname"] . ' ' . $data["lastname"],
            ];

            // Send Mail
            Mail::to($data["email"])->send(new RegisterSuccess($customData));
        } catch (Exception $e) {
            // Mail Error Log
            Log::error('Register Mail Error For User ' . $data["login"] . ': ' . $e->getMessage());
        }

        // Return Data
        return json_encode($return);
    }
}
