<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LibraryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $library = Content::where('type', 'library')->first();
        return view('backend.library.index', compact('library'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'nullable|string',
            'image1' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $images = [];
        $destinationPath = public_path('uploads/library');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Handle image1
        if ($request->hasFile('image1')) {
            $file = $request->file('image1');
            $fileName = 'library_' . time() . '_1_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $images[] = 'public/uploads/library/' . $fileName;
        }

        // Handle image2
        if ($request->hasFile('image2')) {
            $file = $request->file('image2');
            $fileName = 'library_' . time() . '_2_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $images[] = 'public/uploads/library/' . $fileName;
        }

        // Store JSON data in description
        $data = [
            'type' => 'library',
            'title' => 'Library',
            'description' => json_encode([
                'images' => $images,
                'description' => $request->input('description'),
            ]),
            'is_published' => 1,
        ];

        Content::create($data);

        return redirect()->route('library.index')->with('success', 'Library saved successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'description' => 'nullable|string',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $content = Content::findOrFail($id);
        $existingData = json_decode($content->description, true);
        $images = $existingData['images'] ?? [];

        $destinationPath = public_path('uploads/library');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Handle image1
        if ($request->hasFile('image1')) {
            // Delete old image
            if (isset($images[0])) {
                $oldPath = str_replace('public/', '', $images[0]);
                if (file_exists(public_path($oldPath))) {
                    unlink(public_path($oldPath));
                }
            }
            $file = $request->file('image1');
            $fileName = 'library_' . time() . '_1_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $images[0] = 'public/uploads/library/' . $fileName;
        }

        // Handle image2
        if ($request->hasFile('image2')) {
            // Delete old image
            if (isset($images[1])) {
                $oldPath = str_replace('public/', '', $images[1]);
                if (file_exists(public_path($oldPath))) {
                    unlink(public_path($oldPath));
                }
            }
            $file = $request->file('image2');
            $fileName = 'library_' . time() . '_2_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $images[1] = 'public/uploads/library/' . $fileName;
        }

        // Store JSON data in description
        $data = [
            'description' => json_encode([
                'images' => $images,
                'description' => $request->input('description'),
            ]),
        ];

        $content->update($data);

        return redirect()->route('library.index')->with('success', 'Library updated successfully!');
    }

    public function status($id)
    {
        $content = Content::findOrFail($id);
        $content->is_published = !$content->is_published;
        $content->save();

        return redirect()->back()->with('success', 'Status updated successfully!');
    }
}

