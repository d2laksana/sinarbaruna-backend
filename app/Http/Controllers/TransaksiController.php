<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trx = Transaksi::all();
        return response()->json([
            'success' => true,
            'data' => $trx
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'moulding_id' => 'required|exists:mouldings,id'
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $trx = Transaksi::create([
            'user_id' => auth()->user()->id,
            'moulding_id' => $request->moulding_id
        ]);

        if ($trx) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menambahkan transaksi',
                'data' => $trx
            ], 200);
        }
        return response()->json([
            'success' => false,
        ], 409);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        return response()->json([
            'success' => true,
            'data' => $transaksi
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        $validation = Validator::make($request->all(), [
            'user_id' => 'required|exists:user,id',
            'moulding_id' => 'required|exists:moulding,id'
        ]);


        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        try {
            $transaksi->update([
                'user_id' => $request->user_id,
                'moulding_id' => $request->moulding_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil di update',
                'data' => $transaksi
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
    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus data moulding'
        ], 200);
    }
}
