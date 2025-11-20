<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EligibilityCriteriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $eligibilityCriteria = Content::where('type', 'eligibility_criteria_of_college_campus')->first();
        return view('backend.eligibility_criteria.index', compact('eligibilityCriteria'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'links' => 'nullable|array',
            'links.*.title' => 'nullable|string|max:255',
            'links.*.url' => 'nullable|url',
        ]);

        $destinationPath = public_path('uploads/eligibility_criteria');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Handle image upload
        $file = $request->file('image');
        $fileName = 'eligibility_criteria_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($destinationPath, $fileName);
        $imagePath = 'public/uploads/eligibility_criteria/' . $fileName;

        // Process links - filter out empty entries
        $links = [];
        if ($request->has('links')) {
            foreach ($request->input('links') as $link) {
                if (!empty($link['title']) && !empty($link['url'])) {
                    $links[] = [
                        'title' => $link['title'],
                        'url' => $link['url'],
                    ];
                }
            }
        }

        // Store JSON data in description
        $data = [
            'type' => 'eligibility_criteria_of_college_campus',
            'title' => 'Eligibility Criteria of College Campus',
            'file_path' => $imagePath,
            'description' => json_encode([
                'description' => $request->input('description'),
                'links' => $links,
            ]),
            'is_published' => 1,
        ];

        Content::create($data);

        return redirect()->route('eligibility_criteria_of_college_campus.index')->with('success', 'Eligibility Criteria saved successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'links' => 'nullable|array',
            'links.*.title' => 'nullable|string|max:255',
            'links.*.url' => 'nullable|url',
        ]);

        $content = Content::findOrFail($id);
        $destinationPath = public_path('uploads/eligibility_criteria');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $data = [];

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
            $fileName = 'eligibility_criteria_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $data['file_path'] = 'public/uploads/eligibility_criteria/' . $fileName;
        } else {
            $data['file_path'] = $content->file_path;
        }

        // Process links - filter out empty entries
        $links = [];
        if ($request->has('links')) {
            foreach ($request->input('links') as $link) {
                if (!empty($link['title']) && !empty($link['url'])) {
                    $links[] = [
                        'title' => $link['title'],
                        'url' => $link['url'],
                    ];
                }
            }
        }

        // Get existing description data
        $existingData = json_decode($content->description, true);
        if (!$existingData) {
            $existingData = [];
        }

        // Store JSON data in description
        $data['description'] = json_encode([
            'description' => $request->input('description'),
            'links' => $links,
        ]);

        $content->update($data);

        return redirect()->route('eligibility_criteria_of_college_campus.index')->with('success', 'Eligibility Criteria updated successfully!');
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

        return redirect()->route('eligibility_criteria_of_college_campus.index')->with('success', 'Eligibility Criteria deleted successfully!');
    }
}

