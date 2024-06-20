<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\sendResetPassword;
use App\Models\password_reset_tokens;
use App\Models\ResetPasswordToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgotPassword extends Controller
{
    public function forgotpassword(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'email' => 'required|exists:users,email',
            ]);

            if ($validation->fails()) {
                return response()->json($validation->errors(), 422);
            };

            $token = rand(10000, 99999);
            $userToken = ResetPasswordToken::where('email', '=', $request->email)->first();
            // dd($userToken);
            if(!$userToken) {
                ResetPasswordToken::create([
                    'email' => $request->email,
                    'token' => $token,
    
                ]);
            } else {

                $userToken->update([
                    'token' => $token,
                ]);
            }
            

            Mail::to($request->email)->send(new sendResetPassword($token));

            return response()->json([
                'success' => true,
                'message' => "Berhasil mengirim email"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function verifToken(Request $request) {
        try {
            $validation = Validator::make($request->all(), [
                'email' => 'required|exists:reset_password_tokens,email',
                'token' => 'required',
            ]);

            if ($validation->fails()) {
                return response()->json($validation->errors(), 422);
            };

            $cekToken = ResetPasswordToken::where('email', '=', $request->email)->first();
            // dd($cekToken->token);
            if($cekToken->token == $request->token) {

                return response()->json([
                    'success' => true,
                    'message' => "Token Valid"
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => "Token Tidak Valid"
            ], 400);

            
            
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
