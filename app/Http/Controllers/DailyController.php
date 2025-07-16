<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Daily;

class DailyController extends Controller
{
    /**
     * Ambil semua daily milik user login
     */
    public function index(Request $request)
    {
        return $request->user()->daily()
            ->orderBy('tanggal')
            ->orderBy('jam')
            ->get();
    }

    /**
     * Simpan daily baru milik user login
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required|date_format:H:i',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
            'is_checked' => 'boolean'
        ]);

        $validated['user_id'] = $request->user()->id;

        $daily = Daily::create($validated);

        return response()->json($daily, 201);
    }

    /**
     * Tampilkan detail daily milik user login
     */
    public function show(Request $request, $id)
    {
        $daily = $request->user()->daily()->findOrFail($id);
        return response()->json($daily);
    }

    /**
     * Update daily milik user login
     */
    public function update(Request $request, $id)
    {
        $daily = $request->user()->daily()->findOrFail($id);

        $validated = $request->validate([
            'tanggal' => 'sometimes|date',
            'jam' => 'sometimes|date_format:H:i:s',
            'judul' => 'sometimes|string|max:255',
            'deskripsi' => 'nullable|string',
            'prioritas' => 'sometimes|in:rendah,sedang,tinggi',
            'is_checked' => 'sometimes|boolean'
        ]);

        $daily->update($validated);

        return response()->json($id);
    }

    /**
     * Hapus daily milik user login
     */
    public function destroy(Request $request, $id)
    {
        $daily = $request->user()->daily()->findOrFail($id);
        $daily->delete();

        return response()->json(['message' => 'Deleted']);
    }

    /**
     * Update status checklist daily milik user login
     */
    public function updateChecklist(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'is_checked' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $daily = $request->user()->daily()->find($id);

        if (!$daily) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $daily->is_checked = $request->input('is_checked');
        $daily->save();

        return response()->json([
            'message' => 'Status checklist berhasil diperbarui',
            'data' => $daily
        ]);
    }
}
