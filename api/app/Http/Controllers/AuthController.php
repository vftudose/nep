<?php


namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use  App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        /** @var User $user */
        $user = User::where([
            ['email', '=', $request->input('email')],
        ])->first();

        if (!$user) {
            return response()->json([
                'message' => 'user does not exist'
            ], Response::HTTP_CONFLICT);
        }

        if (!app('hash')->check($request->input('password'), $user->password)) {
            return response()->json([
                'message' => 'user does not exist'
            ], Response::HTTP_CONFLICT);
        }

        if ($user->hasTokenExpired()) {
            $user->regenerateToken();
            $user->save();
        }

        return response()->json([
            'token' => $user->api_token,
            'expire' => $user->api_token_expire_date,
            'user' => $user
        ], Response::HTTP_OK);
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        try {
            $user = new User([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => app('hash')->make($request->input('password')),
                'api_token' => Str::random(60),
                'api_token_expire_date' => (new Carbon())->addDays(1)
            ]);

            $user->save();

            return response()->json(['user' => $user], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json(['message' => 'User Registration Failed!'], Response::HTTP_CONFLICT);
        }
    }
}
