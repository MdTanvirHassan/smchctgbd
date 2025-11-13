<?php

namespace App\Http\Controllers;

use App\Models\ClassRoutine;
use App\Models\Classes;
use Illuminate\Http\Request;


class RoutineController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function classroutine()
    {
        $classroutines = ClassRoutine::where('type', 'class')->get();
        $classes = Classes::all();
        return view('backend.class_routine', compact('classroutines', 'classes'));
    }

    public function classroutineStore(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|integer',
            'shift' => 'required|string|max:50',
            'routine_title' => 'required|string|max:255',
            'file_path' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpg,jpeg,png',
            'published_date' => 'required|date',
            'is_active' => 'nullable|boolean'
        ]);

        $file_path = null;
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/uploads/files'), $fileName);
            $file_path = 'public/assets/uploads/files/' . $fileName;
        }

        ClassRoutine::create([
            'class_id' => $validated['class_id'],
            'shift' => $validated['shift'],
            'type' => 'class',
            'routine_title' => $validated['routine_title'],
            'file_path' => $file_path,
            'published_date' => $validated['published_date'],
            'is_active' => 1,
        ]);

        return redirect()->route('classroutine.index')->with('success', 'Routine File added successfully!');
    }

    public function classroutineUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'class_id' => 'required|integer',
            'shift' => 'required|string|max:50',
            'routine_title' => 'required|string|max:255',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpg,jpeg,png',
            'published_date' => 'required|date',
            'is_active' => 'nullable|boolean'
        ]);

        $classRoutine = ClassRoutine::findOrFail($id);

        if ($request->hasFile('file_path')) {
            $oldFilePath = public_path($classRoutine->file_path);
            if ($classRoutine->file_path && file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
            $file = $request->file('file_path');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/uploads/files'), $fileName);
            $file_path = 'public/assets/uploads/files/' . $fileName;
        } else {
            $file_path = $classRoutine->file_path;
        }

        $classRoutine->class_id = $validated['class_id'];
        $classRoutine->shift = $validated['shift'];
        $classRoutine->routine_title = $validated['routine_title'];
        $classRoutine->published_date = $validated['published_date'];
        $classRoutine->is_active = $validated['is_active'] ?? 0;
        $classRoutine->file_path = $file_path;
        $classRoutine->save();

        return redirect()->route('classroutine.index')->with('success', 'Routine File updated successfully.');
    }

    public function classroutineDownload($id)
    {
        $classRoutine = ClassRoutine::findOrFail($id);

        if (!$classRoutine->file_path) {
            return redirect()->back()->with('error', 'File not found.');
        }

        $filePath = public_path(str_replace('public/', '', $classRoutine->file_path));

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'Routine File does not exist on server.');
        }

        return response()->download($filePath);
    }

    public function classroutineStatus($id)
    {
        $classRoutine = ClassRoutine::findOrFail($id);
        $classRoutine->is_active = !$classRoutine->is_active;
        $classRoutine->save();

        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    public function classroutineDestroy($id)
    {
        $classRoutine = ClassRoutine::findOrFail($id);

        if ($classRoutine->file_path) {
            // $filePath = public_path($classRoutine->file_path);
            $filePath = public_path(str_replace('public/', '', $classRoutine->file_path));
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $classRoutine->delete();
        return redirect()->back()->with('error', 'Routine File deleted successfully.');
    }


    public function examroutine()
    {
        $examroutines = ClassRoutine::where('type', 'exam')->get();
        $classes = Classes::all();
        return view('backend.exam_routine', compact('examroutines', 'classes'));
    }

    public function examroutineStore(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|integer',
            'shift' => 'required|string|max:50',
            'routine_title' => 'required|string|max:255',
            'file_path' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpg,jpeg,png',
            'published_date' => 'required|date',
            'is_active' => 'nullable|boolean'
        ]);

        $file_path = null;
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/uploads/files'), $fileName);
            $file_path = 'public/assets/uploads/files/' . $fileName;
        }

        ClassRoutine::create([
            'class_id' => $validated['class_id'],
            'shift' => $validated['shift'],
            'type' => 'exam',
            'routine_title' => $validated['routine_title'],
            'file_path' => $file_path,
            'published_date' => $validated['published_date'],
            'is_active' => 1,
        ]);

        return redirect()->route('examroutine.index')->with('success', 'Routine File added successfully!');
    }

    public function examroutineUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'class_id' => 'required|integer',
            'shift' => 'required|string|max:50',
            'routine_title' => 'required|string|max:255',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpg,jpeg,png',
            'published_date' => 'required|date',
            'is_active' => 'nullable|boolean'
        ]);

        $examRoutine = ClassRoutine::findOrFail($id);

        if ($request->hasFile('file_path')) {
            $oldFilePath = public_path($examRoutine->file_path);
            if ($examRoutine->file_path && file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
            $file = $request->file('file_path');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/uploads/files'), $fileName);
            $file_path = 'public/assets/uploads/files/' . $fileName;
        } else {
            $file_path = $examRoutine->file_path;
        }

        $examRoutine->class_id = $validated['class_id'];
        $examRoutine->shift = $validated['shift'];
        $examRoutine->routine_title = $validated['routine_title'];
        $examRoutine->published_date = $validated['published_date'];
        $examRoutine->file_path = $file_path;

        $examRoutine->save();

        return redirect()->route('examroutine.index')->with('success', 'Routine File updated successfully.');
    }

    public function examroutineDownload($id)
    {
        $examRoutine = ClassRoutine::findOrFail($id);

        if (!$examRoutine->file_path) {
            return redirect()->back()->with('error', 'File not found.');
        }

        // $filePath = public_path($examRoutine->file_path);
        $filePath = public_path(str_replace('public/', '', $examRoutine->file_path));

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'Routine File does not exist on server.');
        }

        return response()->download($filePath);
    }

    public function examroutineStatus($id)
    {
        $examRoutine = ClassRoutine::findOrFail($id);
        $examRoutine->is_active = !$examRoutine->is_active;
        $examRoutine->save();

        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    public function examroutineDestroy($id)
    {
        $examRoutine = ClassRoutine::findOrFail($id);

        if ($examRoutine->file_path) {
            // $filePath = public_path($examRoutine->file_path);
            $filePath = public_path(str_replace('public/', '', $examRoutine->file_path));
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $examRoutine->delete();
        return redirect()->back()->with('error', 'Routine File deleted successfully.');
    }
}
