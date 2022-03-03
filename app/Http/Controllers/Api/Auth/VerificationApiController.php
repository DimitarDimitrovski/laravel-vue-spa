<?php
namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

class VerificationApiController extends Controller
{
    use VerifiesEmails;

    /**
     * Mark the authenticated user’s email address as verified.
     *
     * @param \Illuminate\Http\Request $request
     *
     */
    public function verify(Request $request) {
        $userID = $request['id'];
        $user = User::findOrFail($userID);
        $date = date('Y-m-d g:i:s');
        $user->email_verified_at = $date;
        $user->save();

        return redirect('/cook-profile?verified=1');
    }

    /**
     * Resend the email verification notification.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resend(Request $request)
    {
        $user = User::findOrFail($request['id']);

        if ($user->hasVerifiedEmail()) {
            return response()->json('Email is already verified!', 422);
        }

        $user->sendApiEmailVerificationNotification();
        return response()->json('The email verification link has been resubmitted');
    }
}

