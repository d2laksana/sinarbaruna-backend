<?php

namespace App\Http\Controllers;

use App\Models\Moulding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MouldingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $moulding = Moulding::all();
        return response()->json([
            'success' => true,
            'data' => $moulding
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|string|unique',
            'type_moulding' => 'required|string'
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $moulding = Moulding::create([
            'id' => $request->id,
            'type_moulding' => $request->type_moulding
        ]);

        if ($moulding) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menambahkan moulding',
                'data' => $moulding
            ], 200);
        }

        return response()->json([
            'success' => false,
        ], 409);
    }

    /**
     * Display the specified resource.
     */
    public function show(Moulding $moulding)
    {
        return response()->json([
            'success' => true,
            'data' => $moulding
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Moulding $moulding)
    {
        $validation = Validator::make($request->all(), [
            'type_moulding' => 'required|string'
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        try {
            $moulding->update([
                'type_moulding' => $request->type_moulding
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil di update',
                'data' => $moulding
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
    public function destroy(Moulding $moulding)
    {
        $moulding->delete();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus data moulding'
        ], 200);
    }
}
