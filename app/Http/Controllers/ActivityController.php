<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{

    //TESTING
    // Ambil semua aktivitas berdasarkan hari milik user login
    public function index(Request $request)
    {
        $request->validate([
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu'
        ]);

        return $request->user()->activities()
            ->where('day', $request->day)
            ->orderBy('hour')
            ->orderBy('minute')
            ->get();
    }

    // Simpan aktivitas baru milik user login
    public function store(Request $request)
    {
        $validated = $request->validate([
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'hour' => 'required|integer|min:0|max:23',
            'minute' => 'required|integer|min:0|max:59',
            'description' => 'required|string',
            'is_checked' => 'boolean',
        ]);

        // Tambahkan user_id dari user login
        $validated['user_id'] = $request->user()->id;

        $activity = Activity::create($validated);

        return response()->json($activity, 201);
    }

    // Update aktivitas milik user login
    public function update(Request $request, $id)
    {
        $activity = Activity::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $validated = $request->validate([
            'day' => 'sometimes|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'hour' => 'sometimes|integer|min:0|max:23',
            'minute' => 'sometimes|integer|min:0|max:59',
            'description' => 'sometimes|string',
            'is_checked' => 'sometimes|boolean',
        ]);

        $activity->update($validated);

        return response()->json($activity);
    }

    // Hapus aktivitas milik user login
    public function destroy(Request $request, $id)
    {
        $activity = Activity::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $activity->delete();

        return response()->json(['message' => 'Activity deleted successfully']);
    }

    // Ambil semua aktivitas milik user login, urut berdasarkan hari dan jam
    public function all(Request $request)
    {
        return $request->user()->activities()
            ->orderByRaw("FIELD(day, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')")
            ->orderBy('hour')
            ->orderBy('minute')
            ->get();
    }
}
