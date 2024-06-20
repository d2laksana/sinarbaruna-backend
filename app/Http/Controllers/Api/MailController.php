<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Mail\MyTestEmail;
use App\Models\password_reset_tokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MailController extends Controller
{
    public function testMail(Request $request)
    {
        try {
            $name = "Zegion Support";

            Mail::to('d2laksana.dev@gmail.com')->send(new MyTestEmail($name));
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

    
}
