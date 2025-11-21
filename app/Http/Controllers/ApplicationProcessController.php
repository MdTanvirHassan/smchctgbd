<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationProcessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $applicationProcess = Content::where('type', 'application_process')->first();
        return view('backend.application_process.index', compact('applicationProcess'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'primary_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'secondary_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link_url' => 'nullable|url',
        ]);

        $destinationPath = public_path('uploads/application_process');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Handle primary image upload
        $primaryImagePath = null;
        if ($request->hasFile('primary_image')) {
            $file = $request->file('primary_image');
            $fileName = 'application_process_primary_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $primaryImagePath = 'public/uploads/application_process/' . $fileName;
        }

        // Handle secondary image upload
        $secondaryImagePath = null;
        if ($request->hasFile('secondary_image')) {
            $file = $request->file('secondary_image');
            $fileName = 'application_process_secondary_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $secondaryImagePath = 'public/uploads/application_process/' . $fileName;
        }

        $data = [
            'type' => 'application_process',
            'title' => $request->input('title'),
            'description' => $secondaryImagePath, // Store secondary image path in description field
            'file_path' => $primaryImagePath,
            'link_url' => $request->input('link_url'),
            'is_published' => 1,
        ];

        Content::create($data);

        return redirect()->route('application_process.index')->with('success', 'Application Process saved successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'primary_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'secondary_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link_url' => 'nullable|url',
        ]);

        $content = Content::findOrFail($id);
        $destinationPath = public_path('uploads/application_process');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $data = [
            'title' => $request->input('title'),
            'link_url' => $request->input('link_url'),
        ];

        // Handle primary image upload
        if ($request->hasFile('primary_image')) {
            // Delete old primary image
            if ($content->file_path) {
                $oldPath = str_replace('public/', '', $content->file_path);
                if (file_exists(public_path($oldPath))) {
                    unlink(public_path($oldPath));
                }
            }
            $file = $request->file('primary_image');
            $fileName = 'application_process_primary_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $data['file_path'] = 'public/uploads/application_process/' . $fileName;
        } else {
            $data['file_path'] = $content->file_path;
        }

        // Handle secondary image upload
        if ($request->hasFile('secondary_image')) {
            // Delete old secondary image
            if ($content->description) {
                $oldPath = str_replace('public/', '', $content->description);
                if (file_exists(public_path($oldPath))) {
                    unlink(public_path($oldPath));
                }
            }
            $file = $request->file('secondary_image');
            $fileName = 'application_process_secondary_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $data['description'] = 'public/uploads/application_process/' . $fileName;
        } else {
            $data['description'] = $content->description;
        }

        $content->update($data);

        return redirect()->route('application_process.index')->with('success', 'Application Process updated successfully!');
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
        
        // Delete primary image file
        if ($content->file_path) {
            $oldPath = str_replace('public/', '', $content->file_path);
            if (file_exists(public_path($oldPath))) {
                unlink(public_path($oldPath));
            }
        }

        // Delete secondary image file (stored in description field)
        if ($content->description && strpos($content->description, 'public/uploads/') !== false) {
            $oldPath = str_replace('public/', '', $content->description);
            if (file_exists(public_path($oldPath))) {
                unlink(public_path($oldPath));
            }
        }
        
        $content->delete();

        return redirect()->route('application_process.index')->with('success', 'Application Process deleted successfully!');
    }
}

