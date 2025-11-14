<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FacilitiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $academicFacility = Content::where('type', 'facility_academic_facility')->first();
        $teachingActivities = Content::where('type', 'facility_teaching_activities')->first();
        $activitiesOfMeu = Content::where('type', 'facility_activities_of_meu')->first();
        $researchCell = Content::where('type', 'facility_research_cell')->first();

        return view('backend.facilities.index', compact('academicFacility', 'teachingActivities', 'activitiesOfMeu', 'researchCell'));
    }

    public function store(Request $request, $section)
    {
        $validated = $request->validate($this->getValidationRules($section));

        $data = [
            'type' => 'facility_' . $section,
            'title' => ucfirst(str_replace('_', ' ', $section)),
            'is_published' => 1,
        ];

        // Handle data based on section
        switch ($section) {
            case 'academic_facility':
                $data = $this->handleAcademicFacility($request, $data);
                break;
            case 'teaching_activities':
                $data = $this->handleTeachingActivities($request, $data);
                break;
            case 'activities_of_meu':
                $data = $this->handleActivitiesOfMeu($request, $data);
                break;
            case 'research_cell':
                $data = $this->handleResearchCell($request, $data);
                break;
        }

        Content::create($data);

        return redirect()->route('facilities.index')->with('success', ucfirst(str_replace('_', ' ', $section)) . ' saved successfully!');
    }

    public function update(Request $request, $section, $id)
    {
        $validated = $request->validate($this->getValidationRules($section, true));

        $content = Content::findOrFail($id);
        $data = [];

        // Handle data based on section
        switch ($section) {
            case 'academic_facility':
                $data = $this->handleAcademicFacility($request, $data, $content);
                break;
            case 'teaching_activities':
                $data = $this->handleTeachingActivities($request, $data, $content);
                break;
            case 'activities_of_meu':
                $data = $this->handleActivitiesOfMeu($request, $data, $content);
                break;
            case 'research_cell':
                $data = $this->handleResearchCell($request, $data, $content);
                break;
        }

        $content->update($data);

        return redirect()->route('facilities.index')->with('success', ucfirst(str_replace('_', ' ', $section)) . ' updated successfully!');
    }

    private function getValidationRules($section, $isUpdate = false)
    {
        $rules = [];

        switch ($section) {
            case 'academic_facility':
                $rules = [
                    'image1' => $isUpdate ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' : 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'image2' => $isUpdate ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' : 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'description' => 'nullable|string',
                    'link_url' => 'nullable|url',
                    'academic_calendar_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                ];
                break;
            case 'teaching_activities':
                $rules = [
                    'image1' => $isUpdate ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' : 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'image2' => $isUpdate ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' : 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'image3' => $isUpdate ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' : 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'image4' => $isUpdate ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' : 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'description1' => 'nullable|string',
                    'description2' => 'nullable|string',
                    'link_url' => 'nullable|url',
                ];
                break;
            case 'activities_of_meu':
                $rules = [
                    'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'description' => 'nullable|string',
                    'link_url' => 'nullable|url',
                ];
                break;
            case 'research_cell':
                $rules = [
                    'image1' => $isUpdate ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' : 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'description' => 'nullable|string',
                    'link_url' => 'nullable|url',
                ];
                break;
        }

        return $rules;
    }

    private function handleAcademicFacility($request, $data, $content = null)
    {
        $images = [];
        $destinationPath = public_path('uploads/facilities');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Handle image1
        if ($request->hasFile('image1')) {
            $file = $request->file('image1');
            $fileName = 'academic_facility_' . time() . '_1_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $images[] = 'public/uploads/facilities/' . $fileName;
        } elseif ($content && isset(json_decode($content->description, true)['images'][0])) {
            $images[] = json_decode($content->description, true)['images'][0];
        }

        // Handle image2
        if ($request->hasFile('image2')) {
            $file = $request->file('image2');
            $fileName = 'academic_facility_' . time() . '_2_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $images[] = 'public/uploads/facilities/' . $fileName;
        } elseif ($content && isset(json_decode($content->description, true)['images'][1])) {
            $images[] = json_decode($content->description, true)['images'][1];
        }

        // Handle academic calendar image (stored in file_path)
        if ($request->hasFile('academic_calendar_image')) {
            if ($content && $content->file_path) {
                $oldPath = str_replace('public/', '', $content->file_path);
                if (file_exists(public_path($oldPath))) {
                    unlink(public_path($oldPath));
                }
            }
            $file = $request->file('academic_calendar_image');
            $fileName = 'academic_calendar_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $data['file_path'] = 'public/uploads/facilities/' . $fileName;
        } elseif ($content && $content->file_path) {
            $data['file_path'] = $content->file_path;
        }

        // Store JSON data in description
        $data['description'] = json_encode([
            'images' => $images,
            'description' => $request->input('description'),
            'link_url' => $request->input('link_url'),
        ]);

        $data['link_url'] = $request->input('link_url');

        return $data;
    }

    private function handleTeachingActivities($request, $data, $content = null)
    {
        $images = [];
        $destinationPath = public_path('uploads/facilities');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Handle all 4 images
        for ($i = 1; $i <= 4; $i++) {
            if ($request->hasFile('image' . $i)) {
                $file = $request->file('image' . $i);
                $fileName = 'teaching_activities_' . time() . '_' . $i . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $fileName);
                $images[] = 'public/uploads/facilities/' . $fileName;
            } elseif ($content && isset(json_decode($content->description, true)['images'][$i - 1])) {
                $images[] = json_decode($content->description, true)['images'][$i - 1];
            }
        }

        // Store JSON data in description
        $data['description'] = json_encode([
            'images' => $images,
            'description1' => $request->input('description1'),
            'description2' => $request->input('description2'),
            'link_url' => $request->input('link_url'),
        ]);

        $data['link_url'] = $request->input('link_url');

        // Use first image as file_path
        if (!empty($images)) {
            $data['file_path'] = $images[0];
        }

        return $data;
    }

    private function handleActivitiesOfMeu($request, $data, $content = null)
    {
        $images = [];
        $destinationPath = public_path('uploads/facilities');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Handle image1
        if ($request->hasFile('image1')) {
            $file = $request->file('image1');
            $fileName = 'activities_of_meu_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $images[] = 'public/uploads/facilities/' . $fileName;
        } elseif ($content && isset(json_decode($content->description, true)['images'][0])) {
            $images[] = json_decode($content->description, true)['images'][0];
        }

        // Store JSON data in description
        $data['description'] = json_encode([
            'images' => $images,
            'description' => $request->input('description'),
            'link_url' => $request->input('link_url'),
        ]);

        $data['link_url'] = $request->input('link_url');

        // Use first image as file_path
        if (!empty($images)) {
            $data['file_path'] = $images[0];
        }

        return $data;
    }

    private function handleResearchCell($request, $data, $content = null)
    {
        $destinationPath = public_path('uploads/facilities');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Handle image1
        if ($request->hasFile('image1')) {
            if ($content && $content->file_path) {
                $oldPath = str_replace('public/', '', $content->file_path);
                if (file_exists(public_path($oldPath))) {
                    unlink(public_path($oldPath));
                }
            }
            $file = $request->file('image1');
            $fileName = 'research_cell_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            $data['file_path'] = 'public/uploads/facilities/' . $fileName;
        } elseif ($content && $content->file_path) {
            $data['file_path'] = $content->file_path;
        }

        // Store JSON data in description
        $data['description'] = json_encode([
            'description' => $request->input('description'),
            'link_url' => $request->input('link_url'),
        ]);

        $data['link_url'] = $request->input('link_url');

        return $data;
    }

    public function status($id)
    {
        $content = Content::findOrFail($id);
        $content->is_published = !$content->is_published;
        $content->save();

        return redirect()->back()->with('success', 'Status updated successfully!');
    }
}

