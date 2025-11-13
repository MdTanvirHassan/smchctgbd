<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\ClassResult;
use Illuminate\Http\Request;

class ClassResultController extends Controller
{
    public function classresult()
    {
        $classresults = ClassResult::all();
        $classes = Classes::all();
        return view('backend.class_result', compact('classresults', 'classes'));
    }

    public function classresultStore(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|integer',
            'shift' => 'required|string|max:50',
            'result_title' => 'required|string|max:255',
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

        ClassResult::create([
            'class_id' => $validated['class_id'],
            'shift' => $validated['shift'],
            'result_title' => $validated['result_title'],
            'file_path' => $file_path,
            'published_date' => $validated['published_date'],
            'is_active' => 1,
        ]);

        return redirect()->route('classresult.index')->with('success', 'Result File added successfully!');
    }

    public function classresultUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'class_id' => 'required|integer',
            'shift' => 'required|string|max:50',
            'result_title' => 'required|string|max:255',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpg,jpeg,png',
            'published_date' => 'required|date',
            'is_active' => 'nullable|boolean'
        ]);

        $result = ClassResult::findOrFail($id);

        if ($request->hasFile('file_path')) {
            $oldFilePath = public_path($result->file_path);
            if ($result->file_path && file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
            $file = $request->file('file_path');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/uploads/files'), $fileName);
            $file_path = 'public/assets/uploads/files/' . $fileName;
        } else {
            $file_path = $result->file_path;
        }

        $result->class_id = $validated['class_id'];
        $result->shift = $validated['shift'];
        $result->result_title = $validated['result_title'];
        $result->published_date = $validated['published_date'];
        $result->is_active = $validated['is_active'] ?? 0;
        $result->file_path = $file_path;
        $result->save();

        return redirect()->route('classresult.index')->with('success', 'Result File updated successfully.');
    }

    public function classresultDownload($id)
    {
        $result = ClassResult::findOrFail($id);

        if (!$result->file_path) {
            return redirect()->back()->with('error', 'File not found.');
        }

        // $filePath = public_path($result->file_path);
        $filePath = public_path(str_replace('public/', '', $result->file_path));

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'Result File does not exist on server.');
        }

        return response()->download($filePath);
    }

    public function classresultStatus($id)
    {
        $classResult = ClassResult::findOrFail($id);
        $classResult->is_active = !$classResult->is_active;
        $classResult->save();

        return redirect()->back()->with('success', 'Status updated successfully!');
    }


    public function classresultDestroy($id)
    {
        $result = ClassResult::findOrFail($id);

        if ($result->file_path) {
            // $filePath = public_path($result->file_path);
            $filePath = public_path(str_replace('public/', '', $result->file_path));
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $result->delete();
        return redirect()->back()->with('error', 'Result File deleted successfully.');
    }
}
