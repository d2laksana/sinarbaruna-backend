<?php

namespace App\Http\Controllers;

use App\Models\password_reset_tokens;
use App\Models\ResetPasswordToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json([
            'success' => true,
            'data' => $users
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
            'bagian' => 'required|in:manual,cnc',
            'role' => 'required|in:admin,manajer,kepala bagian,karyawan',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'bagian' => $request->bagian || null,
            'role' => $request->role,
        ]);

        if ($user) {
            return response()->json([
                'success' => true,
                'user'    => $user,
            ], 201);
        }

        return response()->json([
            'success' => false,
        ], 409);
    }

    public function storeKaryawan(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
            'bagian' => 'required|in:manual,cnc',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'bagian' => $request->bagian
        ]);

        if ($user) {
            return response()->json([
                'success' => true,
                'user'    => $user,
            ], 201);
        }

        return response()->json([
            'success' => false,
        ], 409);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response([
            'success' => true,
            'message' => 'Berhasil mendapatkan data users',
            'data' => $user
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
            'bagian' => 'required|in:manual,cnc',
            'role' => 'required|in:admin,manajer,kepala bagian,karyawan',
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        try {
            $user->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil di update',
                'data' => $user
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response([
            'success' => true,
            'message' => 'Berhasil menghapus user'
        ], 200);
    }

    public function updatePassword(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'email' => 'required|exists:users,email',
                'token' => 'required',
                'password' => 'required|confirmed',

            ]);

            if ($validation->fails()) {
                return response()->json($validation->errors(), 422);
            }


            $user = User::where('email', '=', $request->email)->first();
            $token = ResetPasswordToken::where('email', '=', $request->email)->first();
            $token->delete();

            $user->update([
                'password' => Hash::make($request->password)
            ]);


            return response()->json([
                'success' => true,
                'message' => 'Password berhasil di update',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
