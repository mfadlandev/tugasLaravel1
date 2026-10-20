<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Petani;
use Illuminate\Http\Request;

class PetaniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $petanis = Petani::with('kelompoktani')->get();

        return response()->json([
            'success' => true,
            'data' => $petanis
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:20',
            'telp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'id_kelompok_tani' => 'required|exists:kelompok_tani,id_kelompok_tani',
        ]);

        $petani = Petani::create([
            'nama' => $request->nama,
            'nik' => $request->nik,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'id_kelompok_tani' => $request->id_kelompok_tani,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Petani berhasil ditambahkan',
            'data' => $petani
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $petani = Petani::with('kelompoktani')->find($id);

        if (!$petani) {
            return response()->json([
                'success' => false,
                'message' => 'Petani tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $petani
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $petani = Petani::find($id);

        if (!$petani) {
            return response()->json([
                'success' => false,
                'message' => 'Petani tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:20',
            'telp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'id_kelompok_tani' => 'required|exists:kelompok_tani,id_kelompok_tani',
        ]);

        $petani->update($request->only([
            'nama',
            'nik',
            'telp',
            'alamat',
            'id_kelompok_tani',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Data petani berhasil diperbarui',
            'data' => $petani
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $petani = Petani::find($id);

        if (!$petani) {
            return response()->json([
                'success' => false,
                'message' => 'Petani tidak ditemukan'
            ], 404);
        }

        $petani->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data petani berhasil dihapus'
        ]);
    }
}
