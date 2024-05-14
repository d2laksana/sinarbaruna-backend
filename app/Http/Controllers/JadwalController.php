<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jadwal = Jadwal::all();
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
            'mulai_tanggal' => 'required',
            'keterangan' => 'required'
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
            'keterangan' => $request->keterangan,
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
        return response()->json([
            'success' => true,
            'data' => $jadwal
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

        $user = User::where('username', $request->username)->first();

        try {
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

    public function updateKeterangan(Request $request, Jadwal $jadwal)
    {
        $validation = Validator::make($request->all(), [
            'keterangan' => 'required|in:Selesai,Proses,Tidak Selesai'
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

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
}
