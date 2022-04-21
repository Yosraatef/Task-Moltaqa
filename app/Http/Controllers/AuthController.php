<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Routing\Middleware\ThrottleRequests;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {

        // Attempt to log the user in
        if (Auth::attempt($request->validated())) {
            // if successful
            $auth = Auth::user();

            $this->code = 200;
            $this->message = 'login successfully';
            $this->body['user'] = LoginResource::make($auth);
            $this->body['drivers'] = DB::table("users")
                                       ->where('type', 'driver')
                                       ->select("users.id","users.latitude","users.longitude"
                                           , DB::raw("6371 * acos(cos(radians(".$auth->latitude."))
                                            * cos(radians(users.latitude))
                                            * cos(radians(users.longitude) - radians(".$auth->longitude."))
                                            + sin(radians(".$auth->latitude."))
                                            * sin(radians(users.latitude))) AS distance"))
                                       ->orderBy('distance','asc')
                                       ->take(3)
                                       ->get();
        } else {

            $this->message .= ' password error ';
        }

        return self::apiResponse($this->code, $this->message, $this->body);
    }


}
