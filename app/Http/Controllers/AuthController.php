<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Http\Requests\AuthRequests\LoginFormRequest;
use App\Http\Requests\AuthRequests\RegistrationFormRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginFormRequest $request)
    {
        $input = $request->only('email', 'password');
        $token = null;

        if (!$token = JWTAuth::attempt($input)) {
            return AppHelper::loginError();
        }
        DB::connection()->enableQueryLog();
        $user = User::where('email', '=', $request->email)
            ->first();
//         $queries = DB::getQueryLog();
//        return dd($queries);
        if (Hash::check($request->password, $user->password)) {
            return $this->respondWithToken($token, $user->user_id_public);
        } else {
            return AppHelper::loginError();
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {

            JWTAuth::invalidate($request->token);

            return AppHelper::logoutSuccess();

        } catch (JWTException $exception) {

            return AppHelper::logoutError();

        }
    }


    public function register(RegistrationFormRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        if ($user->save()) {
            return new UserResource($user);
        } else {
            return AppHelper::registerError();
        }
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $id)
    {
        return response()->json([
            'success' => true,
            'token' => $token,
            'id' => $id,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
