<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $jadwal = Jadwal::all();
        $jadwal = DB::table('jadwals')
            ->join('users', 'user_id', '=', 'users.id')
            ->select('jadwals.*', 'users.username')
            ->get();


        return response()->json([
            'success' => true,
            'data' => $jadwal
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id_moulding' => 'required',
            'username' => 'required',
            'tanggal' => 'required',
            'type_moulding' => 'required',
            'durasi' => 'required',
            'mulai_tanggal' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $user = User::where('username', $request->username)->first();

        $jadwal = Jadwal::create([
            'id_moulding' => $request->id_moulding,
            'user_id' => $user->id,
            'tanggal' => $request->tanggal,
            'type_moulding' => $request->type_moulding,
            'durasi' => $request->durasi,
            'mulai_tanggal' => $request->mulai_tanggal,
        ]);

        if ($jadwal) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menambahkan jadwal$jadwal',
                'data' => $jadwal
            ], 200);
        }

        return response()->json([
            'success' => false,
        ], 409);
    }

    /**
     * Display the specified resource.
     */
    public function show(Jadwal $jadwal)
    {
        $jad = DB::table('jadwals')
            ->join('users', 'user_id', '=', 'users.id')
            ->select('jadwals.*', 'users.username')
            ->where('jadwals.id', '=', $jadwal->id)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $jad
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        $validation = Validator::make($request->all(), [
            'id_moulding' => 'required',
            'username' => 'required',
            'tanggal' => 'required',
            'type_moulding' => 'required',
            'durasi' => 'required',
            'mulai_tanggal' => 'required',
            'keterangan' => 'required|in:Selesai,Proses,Tidak Selesai'
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }



        try {
            $user = User::where('username', $request->username)->first();
            if (!$user) return response()->json([
                "success" => false,
                "message" => "Username not found"
            ], 404);

            $jadwal->update([
                'id_moulding' => $request->id_moulding,
                'user_id' => $user->id,
                'tanggal' => $request->tanggal,
                'type_moulding' => $request->type_moulding,
                'durasi' => $request->durasi,
                'mulai_tanggal' => $request->mulai_tanggal,
                'keterangan' => $request->keterangan,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil di update',
                'data' => $jadwal
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
    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus data jadwal'
        ], 200);
    }

    public function updateKeterangan(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'keterangan' => 'required|in:Selesai,Proses,Tidak Selesai'
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }
        $jadwal = Jadwal::find($id);

        try {
            $jadwal->update([
                'keterangan' => $request->keterangan,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil di update',
                'data' => $jadwal
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getJadwal()
    {
        $user = auth()->user();

        // search jadwal berdasarkan user id yang login
        // $jadwal = Jadwal::where('user_id', $user->id)->get();

        $kepalabagian = User::where('bagian', $user->bagian)->where('role', "kepala bagian")->first();

        // search jadwal berdasarkan kepala bagian
        // $jadwalKepala = Jadwal::where('user_id', $kepalabagian->id)->get();
        $jadwalKepala = DB::table('jadwals')
            ->join('users', 'user_id', '=', 'users.id')
            ->select('jadwals.*', 'users.username')
            ->where('jadwals.user_id', '=', $kepalabagian->id)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $jadwalKepala
        ], 200);
    }
}
