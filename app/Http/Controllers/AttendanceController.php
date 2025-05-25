<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Tampilan dashboard absensi
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();

        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        $attendances = Attendance::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('attendance.index', compact('attendance', 'attendances'));
    }

    // Proses check in
    public function checkIn(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();
        $now = Carbon::now()->toTimeString();

        // Cek apakah sudah check in hari ini
        $existing = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Anda sudah melakukan check in hari ini.');
        }

        Attendance::create([
            'user_id' => $user->id,
            'date' => $today,
            'check_in' => $now,
            'status' => 'hadir'
        ]);

        return redirect()->back()->with('success', 'Check in berhasil dicatat.');
    }

    // Proses check out
    public function checkOut(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();
        $now = Carbon::now()->toTimeString();

        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if (!$attendance) {
            return redirect()->back()->with('error', 'Anda belum melakukan check in hari ini.');
        }

        if ($attendance->check_out) {
            return redirect()->back()->with('error', 'Anda sudah melakukan check out hari ini.');
        }

        $attendance->update([
            'check_out' => $now
        ]);

        return redirect()->back()->with('success', 'Check out berhasil dicatat.');
    }

    // Tampilan admin untuk melihat semua absensi
    public function adminIndex()
    {
        if (!Auth::user()->isAdmin()) {
            return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $attendances = Attendance::with('user')
            ->orderBy('date', 'desc')
            ->paginate(15);

        return view('admin.attendance.index', compact('attendances'));
    }

}