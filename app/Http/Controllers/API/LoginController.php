<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|max:255|min:6|confirmed',
            'phoneNumber' => 'required|string|max:255|min:11',
            'gender' => 'required|string',
            'profilePhoto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'roles' => 'required'
        ]);

        if($validator->fails())
        {
            return response(['errors' => $validator->errors()], 422);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->phone_number = $request->phoneNumber;
        $user->gender = $request->gender;
        $user->roles = $request->roles;

        if($request->file('profilePhoto'))
        {
            $file = $request->file('profilePhoto')->store('user', 'public');
            $user->profile_photo = $file;
        }

        $user->save();

        return $this->getResponse($user);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|max:255|min:6',
        ]);

        if($validator->fails())
        {
            return response(['errors' => $validator->errors()], 422);
        }

        $credentials = \request(['email', 'password']);

        if(Auth::attempt($credentials))
        {
            $user = $request->user();
            return $this->getResponse($user);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response('successfully logout', 200);
    }

    public function user(Request $request)
    {
        return $request->user();
    }

    public function updateprofile(Request $request)
    {
        $data = $request->except(['profilePhoto']);

        $user = $request->user();
        $user->update($data);
        return response('success update', 200);
    }

    public function updatephoto(Request $request)
    {
        $user = $request->user();

        if($request->file('profilePhoto'))
        {
            $file = $request->file('profilePhoto')->store('user', 'public');
            $user->profile_photo = $file;
        }

        $data = [
            'profile_photo' => $file
        ];

        $user->update($data);
        return response('success update', 200);

    }

    private function getResponse(User $user)
    {
        //create Token
        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeek(1);
        $token->save();

        return ResponseFormatter::success([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ], 200);
    }
}
