<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $schedules = $user->schedules()->latest()->get();

        return response()->json([
            'message' => 'Schedules retrieved successfully',
            'schedules' => $schedules
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'meeting_date' => 'required|date',
            'meeting_time' => 'required',
            'description' => 'nullable|string',
            'minutes' => 'nullable|string'
        ]);

        $schedule = $request->user()->schedules()->create([
            'title' => $request->title,
            'priority' => $request->priority,
            'meeting_date' => $request->meeting_date,
            'meeting_time' => $request->meeting_time,
            'description' => $request->description,
            'minutes' => $request->minutes,
        ]);

        return response()->json([
            'message' => 'Schedule created successfully',
            'schedule' => $schedule
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $schedule = $user->schedules()->find($id);

        if (!$schedule) {
            return response()->json(['message' => 'Schedule not found or not authorized.'], 404);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'meeting_date' => 'required|date',
            'meeting_time' => 'required',
            'description' => 'nullable|string',
            'minutes' => 'nullable|string'
        ]);

        $schedule->update($request->only([
            'title', 'priority', 'meeting_date', 'meeting_time', 'description', 'minutes'
        ]));

        return response()->json([
            'message' => 'Schedule updated successfully',
            'schedule' => $schedule
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $schedule = $request->user()->schedules()->find($id);

        if (!$schedule) {
            return response()->json(['message' => 'Schedule not found or not authorized.'], 404);
        }

        $schedule->delete();

        return response()->json(['message' => 'Schedule deleted successfully']);
    }

    public function updateChecklist(Request $request, $id)
    {
        $request->validate(['is_checked' => 'required|boolean']);

        $schedule = $request->user()->schedules()->find($id);

        if (!$schedule) {
            return response()->json(['message' => 'Agenda tidak ditemukan atau tidak diizinkan'], 404);
        }

        $schedule->is_checked = $request->is_checked;
        $schedule->save();

        return response()->json([
            'message' => 'Status checklist berhasil diperbarui',
            'schedule' => $schedule
        ]);
    }
}
