<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HostelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $hostel = Content::where('type', 'hostel')->first();
        return view('backend.hostel.index', compact('hostel'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'boys_image1' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'boys_image2' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'girls_image1' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'girls_image2' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $destinationPath = public_path('uploads/hostel');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $boysImages = [];
        $girlsImages = [];

        // Handle boys hostel images
        if ($request->hasFile('boys_image1')) {
            $file = $request->file('boys_image1');
            $fileName = 'boys_hostel_' . time() . '_1_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $boysImages[] = 'public/uploads/hostel/' . $fileName;
        }

        if ($request->hasFile('boys_image2')) {
            $file = $request->file('boys_image2');
            $fileName = 'boys_hostel_' . time() . '_2_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $boysImages[] = 'public/uploads/hostel/' . $fileName;
        }

        // Handle girls hostel images
        if ($request->hasFile('girls_image1')) {
            $file = $request->file('girls_image1');
            $fileName = 'girls_hostel_' . time() . '_1_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $girlsImages[] = 'public/uploads/hostel/' . $fileName;
        }

        if ($request->hasFile('girls_image2')) {
            $file = $request->file('girls_image2');
            $fileName = 'girls_hostel_' . time() . '_2_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $girlsImages[] = 'public/uploads/hostel/' . $fileName;
        }

        // Store JSON data in description
        $data = [
            'type' => 'hostel',
            'title' => 'Hostel',
            'description' => json_encode([
                'boys_images' => $boysImages,
                'girls_images' => $girlsImages,
            ]),
            'is_published' => 1,
        ];

        Content::create($data);

        return redirect()->route('hostel.index')->with('success', 'Hostel saved successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'boys_image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'boys_image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'girls_image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'girls_image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $content = Content::findOrFail($id);
        $existingData = json_decode($content->description, true);
        $boysImages = $existingData['boys_images'] ?? [];
        $girlsImages = $existingData['girls_images'] ?? [];

        $destinationPath = public_path('uploads/hostel');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Handle boys hostel images
        if ($request->hasFile('boys_image1')) {
            if (isset($boysImages[0])) {
                $oldPath = str_replace('public/', '', $boysImages[0]);
                if (file_exists(public_path($oldPath))) {
                    unlink(public_path($oldPath));
                }
            }
            $file = $request->file('boys_image1');
            $fileName = 'boys_hostel_' . time() . '_1_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $boysImages[0] = 'public/uploads/hostel/' . $fileName;
        }

        if ($request->hasFile('boys_image2')) {
            if (isset($boysImages[1])) {
                $oldPath = str_replace('public/', '', $boysImages[1]);
                if (file_exists(public_path($oldPath))) {
                    unlink(public_path($oldPath));
                }
            }
            $file = $request->file('boys_image2');
            $fileName = 'boys_hostel_' . time() . '_2_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $boysImages[1] = 'public/uploads/hostel/' . $fileName;
        }

        // Handle girls hostel images
        if ($request->hasFile('girls_image1')) {
            if (isset($girlsImages[0])) {
                $oldPath = str_replace('public/', '', $girlsImages[0]);
                if (file_exists(public_path($oldPath))) {
                    unlink(public_path($oldPath));
                }
            }
            $file = $request->file('girls_image1');
            $fileName = 'girls_hostel_' . time() . '_1_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $girlsImages[0] = 'public/uploads/hostel/' . $fileName;
        }

        if ($request->hasFile('girls_image2')) {
            if (isset($girlsImages[1])) {
                $oldPath = str_replace('public/', '', $girlsImages[1]);
                if (file_exists(public_path($oldPath))) {
                    unlink(public_path($oldPath));
                }
            }
            $file = $request->file('girls_image2');
            $fileName = 'girls_hostel_' . time() . '_2_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $girlsImages[1] = 'public/uploads/hostel/' . $fileName;
        }

        // Store JSON data in description
        $data = [
            'description' => json_encode([
                'boys_images' => $boysImages,
                'girls_images' => $girlsImages,
            ]),
        ];

        $content->update($data);

        return redirect()->route('hostel.index')->with('success', 'Hostel updated successfully!');
    }

    public function status($id)
    {
        $content = Content::findOrFail($id);
        $content->is_published = !$content->is_published;
        $content->save();

        return redirect()->back()->with('success', 'Status updated successfully!');
    }
}

