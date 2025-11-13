<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return response()->json(['status' => 'error', 'message' => 'Current password is incorrect']);
        }

        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Password updated successfully']);
    }


    public function dashboard()
    {
        $teacher = Teacher::count();
        $student = Student::count();
        $notices = Content::where('type', 'notice')
            ->get();
        return view('backend.dashboard', compact('teacher', 'student', 'notices'));
    }
}
