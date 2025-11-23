<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CafeteriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cafeteria = Content::where('type', 'cafeteria')->first();
        return view('backend.cafeteria.index', compact('cafeteria'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $images = [];
        $destinationPath = public_path('uploads/cafeteria');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Handle multiple images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $fileName = 'cafeteria_' . time() . '_' . ($index + 1) . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $fileName);
                $images[] = 'public/uploads/cafeteria/' . $fileName;
            }
        }

        // Store JSON data in description
        $data = [
            'type' => 'cafeteria',
            'title' => 'Cafeteria',
            'description' => json_encode([
                'images' => $images,
            ]),
            'is_published' => 1,
        ];

        Content::create($data);

        return redirect()->route('cafeteria.index')->with('success', 'Cafeteria saved successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'existing_images' => 'nullable|array',
            'existing_images.*' => 'nullable|string',
        ]);

        $content = Content::findOrFail($id);
        $existingData = json_decode($content->description, true);
        $images = $request->input('existing_images', []);

        $destinationPath = public_path('uploads/cafeteria');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Handle new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $fileName = 'cafeteria_' . time() . '_' . ($index + 1) . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $fileName);
                $images[] = 'public/uploads/cafeteria/' . $fileName;
            }
        }

        // Remove deleted images
        $allExistingImages = $existingData['images'] ?? [];
        $deletedImages = array_diff($allExistingImages, $images);
        foreach ($deletedImages as $deletedImage) {
            $oldPath = str_replace('public/', '', $deletedImage);
            if (file_exists(public_path($oldPath))) {
                unlink(public_path($oldPath));
            }
        }

        // Store JSON data in description
        $data = [
            'description' => json_encode([
                'images' => $images,
            ]),
        ];

        $content->update($data);

        return redirect()->route('cafeteria.index')->with('success', 'Cafeteria updated successfully!');
    }

    public function status($id)
    {
        $content = Content::findOrFail($id);
        $content->is_published = !$content->is_published;
        $content->save();

        return redirect()->back()->with('success', 'Status updated successfully!');
    }
}

