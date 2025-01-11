<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use App\Mail\PasswordResetMail;
use App\Mail\MFAEmail;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Customer Portal API",
 *     version="1.0.0",
 *     description="API for managing customer data.",
 *     @OA\Contact(
 *         email="support@example.com"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 */



class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Login a user",
     *     description="Authenticate a user and send an MFA token to their email for verification.",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="sukhpal@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="Sukhpal123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="MFA token sent to user's email.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="user_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $mfaToken = rand(100000, 999999);
            $user->mfa_token = $mfaToken;
            $user->mfa_token_expires_at = now()->addMinutes(10);
            $user->save();

            Mail::to($user->email)->send(new MFAEmail($mfaToken));

            return response()->json([
                'message' => 'Please check your email for the MFA token.',
                'user_id' => $user->id,
            ]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * @OA\Post(
     *     path="/api/mfa",
     *     summary="Verify MFA Token",
     *     description="Verify the MFA token sent to the user's email and return an access token.",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"mfa_token", "user_id"},
     *             @OA\Property(property="mfa_token", type="integer", example=123456),
     *             @OA\Property(property="user_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid or expired MFA token")
     * )
     */
    public function verifyMFA(Request $request)
    {
        $request->validate([
            'mfa_token' => 'required|numeric',
        ]);

        $user = User::find($request->user_id);

        if ($user->mfa_token === $request->mfa_token && Carbon::now()->lessThanOrEqualTo($user->mfa_token_expires_at)) {
            $token = $user->createToken('YourApp')->accessToken;

            $user->mfa_token = null;
            $user->mfa_token_expires_at = null;
            $user->save();

            return response()->json([
                'token' => $token,
                'message' => 'Login successful',
            ]);
        }

        return response()->json(['error' => 'Invalid or expired MFA token'], 400);
    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register a new user",
     *     description="Register a user and return an access token.",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "password_confirmation"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="sukhpal2@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="Sukhpal123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="Sukhpal123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Registration successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="token", type="string")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('YourAppName')->accessToken;

        return response()->json([
            'message' => 'Registration successful',
            'token' => $token,
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/password/email",
     *     summary="Send password reset link",
     *     description="Send a password reset link to the user's email address.",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string", format="email", example="sukhpal@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password reset link sent",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Password reset link sent to your email.")
     *         )
     *     ),
     *     @OA\Response(response=404, description="No user found with this email address."),
     *     @OA\Response(response=400, description="Unable to send reset link")
     * )
     */


    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'No user found with this email address.'], 404);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Password reset link sent to your email.']);
        }

        return response()->json(['error' => 'Unable to send reset link'], 400);
    }

    /**
     * @OA\Post(
     *     path="/api/password/reset",
     *     summary="Reset user password",
     *     description="Reset the password using the reset token.",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"token", "email", "password", "password_confirmation"},
     *             @OA\Property(property="token", type="string", example="reset-token"),
     *             @OA\Property(property="email", type="string", format="email", example="sukhpal@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="Sukhpal123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="Sukhpal123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password reset successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Password reset successful")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Invalid token or unable to reset password")
     * )
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Password reset successful']);
        }

        return response()->json(['error' => 'Unable to reset password'], 400);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Logout a user",
     *     description="Revoke the user's access token to log them out.",
     *     tags={"Authentication"},
     *     @OA\Response(
     *         response=200,
     *         description="Logout successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logout successful")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Logout successful']);
    }
}
