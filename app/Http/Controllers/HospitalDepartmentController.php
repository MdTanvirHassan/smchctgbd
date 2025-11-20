<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HospitalDepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $indoorPatient = Content::where('type', 'hospital_indoor_patient_department')->first();
        $outPatient = Content::where('type', 'hospital_out_patient_department')->first();
        
        return view('backend.hospital_department.index', compact('indoorPatient', 'outPatient'));
    }

    public function store(Request $request, $department)
    {
        $validated = $request->validate([
            'categories' => 'required|array|min:1',
            'categories.*.name' => 'required|string|max:255',
            'categories.*.images' => 'nullable',
            'categories.*.images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $destinationPath = public_path('uploads/hospital_department');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $categories = [];
        
        foreach ($request->input('categories') as $index => $categoryData) {
            $category = [
                'name' => $categoryData['name'],
                'images' => []
            ];

            // Handle image uploads for this category
            if ($request->hasFile("categories.{$index}.images")) {
                foreach ($request->file("categories.{$index}.images") as $image) {
                    if ($image && $image->isValid()) {
                        $fileName = $department . '_' . time() . '_' . uniqid() . '_' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                        $image->move($destinationPath, $fileName);
                        $category['images'][] = 'public/uploads/hospital_department/' . $fileName;
                    }
                }
            }

            $categories[] = $category;
        }

        $data = [
            'type' => 'hospital_' . $department,
            'title' => ucwords(str_replace('_', ' ', $department)),
            'description' => json_encode(['categories' => $categories]),
            'is_published' => 1,
        ];

        Content::create($data);

        return redirect()->route('hospital_department.index')->with('success', ucwords(str_replace('_', ' ', $department)) . ' saved successfully!');
    }

    public function update(Request $request, $department, $id)
    {
        $validated = $request->validate([
            'categories' => 'required|array|min:1',
            'categories.*.name' => 'required|string|max:255',
            'categories.*.images' => 'nullable',
            'categories.*.images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories.*.existing_images' => 'nullable',
        ]);

        $content = Content::findOrFail($id);
        $destinationPath = public_path('uploads/hospital_department');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $existingData = json_decode($content->description, true);
        $existingCategories = $existingData['categories'] ?? [];

        $categories = [];
        
        foreach ($request->input('categories') as $index => $categoryData) {
            $category = [
                'name' => $categoryData['name'],
                'images' => []
            ];

            // Keep existing images if provided
            if (isset($categoryData['existing_images']) && is_array($categoryData['existing_images'])) {
                $category['images'] = $categoryData['existing_images'];
            }

            // Handle new image uploads for this category
            if ($request->hasFile("categories.{$index}.images")) {
                foreach ($request->file("categories.{$index}.images") as $image) {
                    if ($image && $image->isValid()) {
                        $fileName = $department . '_' . time() . '_' . uniqid() . '_' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                        $image->move($destinationPath, $fileName);
                        $category['images'][] = 'public/uploads/hospital_department/' . $fileName;
                    }
                }
            }

            $categories[] = $category;
        }

        // Delete removed images
        $this->deleteRemovedImages($existingCategories, $categories);

        $data = [
            'description' => json_encode(['categories' => $categories]),
        ];

        $content->update($data);

        return redirect()->route('hospital_department.index')->with('success', ucwords(str_replace('_', ' ', $department)) . ' updated successfully!');
    }

    private function deleteRemovedImages($oldCategories, $newCategories)
    {
        $oldImages = [];
        foreach ($oldCategories as $category) {
            if (isset($category['images'])) {
                $oldImages = array_merge($oldImages, $category['images']);
            }
        }

        $newImages = [];
        foreach ($newCategories as $category) {
            if (isset($category['images'])) {
                $newImages = array_merge($newImages, $category['images']);
            }
        }

        $removedImages = array_diff($oldImages, $newImages);
        
        foreach ($removedImages as $imagePath) {
            $filePath = str_replace('public/', '', $imagePath);
            if (file_exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }
        }
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
        
        // Delete all images
        $data = json_decode($content->description, true);
        if (isset($data['categories'])) {
            foreach ($data['categories'] as $category) {
                if (isset($category['images'])) {
                    foreach ($category['images'] as $imagePath) {
                        $filePath = str_replace('public/', '', $imagePath);
                        if (file_exists(public_path($filePath))) {
                            unlink(public_path($filePath));
                        }
                    }
                }
            }
        }
        
        $content->delete();

        return redirect()->route('hospital_department.index')->with('success', 'Department deleted successfully!');
    }
}

