<?php

namespace App\Http\Controllers\V1;

use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;

class VerifyEmailController extends Controller
{

    public function __invoke(Request $request)
    {
        $user = User::find($request->route('id'));

        if ($user->hasVerifiedEmail()) {
            return "Email is already verified.";
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return "Email verification successfull.";
    }
}