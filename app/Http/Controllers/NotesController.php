<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NotesController extends Controller
{
   public function index(Request $request)
{
    try {
        // Pastikan user bisa akses notes
        $notes = $request->user()->notes()->orderByDesc('updated_at')->get();

        return response()->json([
            'status' => 'success',
            'data' => $notes
        ]);
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Error fetching notes: ' . $e->getMessage());

        return response()->json([
            'status' => 'error',
            'message' => 'Gagal mengambil catatan'
        ], 500);
    }
}

public function show(Request $request, $id)
{
    $note = $request->user()->notes()->findOrFail($id);
    return response()->json($note);
}

public function store(Request $request)
{
    $request->validate(['content' => 'required|string']);

    $note = $request->user()->notes()->create([
        'content' => $request->content
    ]);

    return response()->json($note, 201);
}

public function update(Request $request, $id)
{
    $request->validate([
        'content' => 'required|string'
    ]);

    $note = $request->user()->notes()->findOrFail($id);
    $note->update(['content' => $request->content]);

    return response()->json($note);
}

public function destroy(Request $request, $id)
{
    $note = $request->user()->notes()->findOrFail($id);
    $note->delete();

    return response()->json(null, 204);
}

public function search(Request $request)
{
    $keyword = $request->query('q', '');

    $notes = $request->user()->notes()
        ->where('content', 'LIKE', "%$keyword%")
        ->orderBy('updated_at', 'desc')
        ->get();

    return response()->json($notes);
}

}
