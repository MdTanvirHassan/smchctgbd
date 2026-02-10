<?php

namespace App\Http\Controllers;

use App\Models\IerbActivity;
use App\Models\IerbMember;
use Illuminate\Http\Request;

class IerbController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $members = IerbMember::orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();
        $activities = IerbActivity::orderBy('activity_date', 'desc')->get();

        return view('backend.ierb.index', compact('members', 'activities'));
    }

    public function memberStore(Request $request)
    {
        $validated = $request->validate([
            'name_affiliation' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        IerbMember::create($validated);

        return redirect()->route('ierb_member.index')->with('success', 'IERB member added successfully!');
    }

    public function memberUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'name_affiliation' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $member = IerbMember::findOrFail($id);
        $member->update($validated);

        return redirect()->route('ierb_member.index')->with('success', 'IERB member updated successfully.');
    }

    public function memberDestroy($id)
    {
        $member = IerbMember::findOrFail($id);
        $member->delete();

        return redirect()->back()->with('error', 'IERB member deleted successfully.');
    }

    public function activityStore(Request $request)
    {
        $validated = $request->validate([
            'topic' => 'required|string|max:500',
            'principal_investigator' => 'required|string|max:255',
            'activity_date' => 'required|date',
        ]);

        IerbActivity::create($validated);

        return redirect()->route('ierb_member.index')->with('success', 'IERB activity added successfully!');
    }

    public function activityUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'topic' => 'required|string|max:500',
            'principal_investigator' => 'required|string|max:255',
            'activity_date' => 'required|date',
        ]);

        $activity = IerbActivity::findOrFail($id);
        $activity->update($validated);

        return redirect()->route('ierb_member.index')->with('success', 'IERB activity updated successfully.');
    }

    public function activityDestroy($id)
    {
        $activity = IerbActivity::findOrFail($id);
        $activity->delete();

        return redirect()->back()->with('error', 'IERB activity deleted successfully.');
    }
}
