<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Auth\Events\Registered;

use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function register(UserRegistrationRequest $request) {

        //I handle exception here, because if any fatal error appear in DB or server side when submit the request, exception message should be appear in json format

        try {

            $user = User::create($request->validated());

            event(new Registered($user));

            $user->sendEmailVerificationNotification();

            if(!$user) return $this->getResponse(400, 'Bad request');
            return $this->getResponse(201, 'User registration successfull. Please check your email for verification', $user);

        } catch(\Exception $e) {

            return $this->getResponse(500, $e->getMessage());
        }
    }

    public function login(Request $request) {

        

        //I didn't use another form request for login part. Because the validation rules are not many fields.

        $request->validate([
            'email' => 'required|string|email|exists:users,email',
            'password' => ['required', Password::min(6)->letters()
                                                        ->mixedCase()
                                                        ->numbers()
                                                        ->symbols()]
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user) return $this->getResponse(404, 'User not found!');

        if(!$user->hasVerifiedEmail()) return $this->getResponse(400, 'Email is not verified yet!');

        if($user->status != 1) $this->getResponse(400, 'User is not activated yet!');

        $check_password = Hash::check($request->password, $user->password);

        if(!$check_password) $this->getResponse(400, 'Password does not match!');

        $token = $user->createToken('user-token');

        if($token) {

            $response = [
                'user' => $user,
                'token' => $token->plainTextToken
            ];

            return $this->getResponse(200, 'Successfully logged in.', $response);

        } else {

            return $this->getResponse(500, 'Something went wrong.');
        }
    }
}
