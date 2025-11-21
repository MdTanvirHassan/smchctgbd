<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganogramController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $organogram = Content::where('type', 'organogram')->first();
        return view('backend.organogram.index', compact('organogram'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link_url' => 'nullable|url',
        ]);

        $destinationPath = public_path('uploads/organogram');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Handle image upload
        $file = $request->file('image');
        $fileName = 'organogram_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($destinationPath, $fileName);
        $imagePath = 'public/uploads/organogram/' . $fileName;

        $data = [
            'type' => 'organogram',
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'file_path' => $imagePath,
            'link_url' => $request->input('link_url'),
            'is_published' => 1,
        ];

        Content::create($data);

        return redirect()->route('organogram.index')->with('success', 'Organogram saved successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link_url' => 'nullable|url',
        ]);

        $content = Content::findOrFail($id);
        $destinationPath = public_path('uploads/organogram');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $data = [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'link_url' => $request->input('link_url'),
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($content->file_path) {
                $oldPath = str_replace('public/', '', $content->file_path);
                if (file_exists(public_path($oldPath))) {
                    unlink(public_path($oldPath));
                }
            }
            $file = $request->file('image');
            $fileName = 'organogram_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $data['file_path'] = 'public/uploads/organogram/' . $fileName;
        } else {
            $data['file_path'] = $content->file_path;
        }

        $content->update($data);

        return redirect()->route('organogram.index')->with('success', 'Organogram updated successfully!');
    }

    public function status($id)
    {
        $content = Content::findOrFail($id);
        $content->is_published = !$content->is_published;
        $content->save();

        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    public function destroy($id)
    {
        $content = Content::findOrFail($id);
        
        // Delete image file
        if ($content->file_path) {
            $oldPath = str_replace('public/', '', $content->file_path);
            if (file_exists(public_path($oldPath))) {
                unlink(public_path($oldPath));
            }
        }
        
        $content->delete();

        return redirect()->route('organogram.index')->with('success', 'Organogram deleted successfully!');
    }
}

