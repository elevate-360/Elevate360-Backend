<?php

namespace App\Http\Middleware;

use Closure;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('authToken');
        if ($token) {
            $agent = new Agent();
            $browserInfo = $request->userAgent();
            $os = $agent->platform();
            $device = $agent->device();

            if ($os && $device) {
                $userData = DB::table('tblUser')
                    ->join('tblUserLoginLog', 'tblUser.userId', '=', 'tblUserLoginLog.userId')
                    ->select(
                        'tblUserLoginLog.browserInfo',
                        'tblUserLoginLog.operatingSystem',
                        'tblUserLoginLog.deviceType',
                        'tblUser.isEmailVerified',
                        'tblUser.userId',
                        'tblUser.isContactNumberVerified'
                    )
                    ->where('tblUser.userSecret', '=', $token)
                    ->orderBy('tblUserLoginLog.loginTime', 'DESC')
                    ->limit(1)
                    ->get()
                    ->first();

                if ($userData) {
                    // Check all the details
                    $reqHash = hash('sha512', $browserInfo . (($os) ? $os : "0") . (($device) ? $device : "0") . $token);
                    $expHash = hash('sha512', $userData->browserInfo . $userData->operatingSystem . $userData->deviceType . $token);

                    if ($reqHash == $expHash) {
                        unset($reqHash);
                        unset($expHash);
                        return $next($request);
                    } else {
                        return response()->json(['error' => 'Unauthorized'], 401);
                    }
                } else {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
            } else {
                return response()->json(['attitude' => 'Hmmm! Trying to hack ahh.............'], 401);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
