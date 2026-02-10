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
            'pdfs.*' => 'nullable|file|mimes:pdf|max:10240',
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

        // Handle multiple PDF uploads
        $pdfs = [];
        if ($request->hasFile('pdfs')) {
            $pdfTitles = $request->input('pdf_titles', []);
            $pdfIndex = 0;
            foreach ($request->file('pdfs') as $pdfFile) {
                if ($pdfFile && $pdfFile->isValid()) {
                    $pdfFileName = 'eligibility_criteria_pdf_' . time() . '_' . uniqid() . '.' . $pdfFile->getClientOriginalExtension();
                    $pdfFile->move($destinationPath, $pdfFileName);
                    $pdfPath = 'public/uploads/eligibility_criteria/' . $pdfFileName;
                    $pdfTitle = !empty($pdfTitles[$pdfIndex]) ? $pdfTitles[$pdfIndex] : basename($pdfPath);
                    $pdfs[] = [
                        'path' => $pdfPath,
                        'title' => $pdfTitle
                    ];
                    $pdfIndex++;
                }
            }
        }

        // Store JSON data in description
        $data = [
            'type' => 'eligibility_criteria_of_college_campus',
            'title' => 'Mission & Vision',
            'file_path' => $imagePath,
            'description' => json_encode([
                'description' => $request->input('description'),
                'pdfs' => $pdfs,
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
            'pdfs.*' => 'nullable|file|mimes:pdf|max:10240',
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

        // Get existing description data
        $existingData = json_decode($content->description, true);
        if (!$existingData) {
            $existingData = [];
        }

        // Handle existing PDFs - keep those that are not deleted
        $pdfs = [];
        $existingPdfs = $existingData['pdfs'] ?? [];
        $deletedPdfs = $request->input('deleted_pdfs', []);
        $deletedPdfsArray = is_array($deletedPdfs) ? $deletedPdfs : [];
        $existingPdfTitles = $request->input('existing_pdf_titles', []);
        
        if ($request->has('existing_pdfs')) {
            foreach ($request->input('existing_pdfs') as $index => $pdfPath) {
                // Check if this PDF is marked for deletion
                if (!in_array($pdfPath, $deletedPdfsArray)) {
                    $pdfTitle = !empty($existingPdfTitles[$index]) ? $existingPdfTitles[$index] : basename($pdfPath);
                    $pdfs[] = [
                        'path' => $pdfPath,
                        'title' => $pdfTitle
                    ];
                } else {
                    // Delete the PDF file
                    $oldPdfPath = str_replace('public/', '', $pdfPath);
                    if (file_exists(public_path($oldPdfPath))) {
                        unlink(public_path($oldPdfPath));
                    }
                }
            }
        }

        // Handle new PDF uploads
        if ($request->hasFile('pdfs')) {
            $pdfTitles = $request->input('pdf_titles', []);
            $pdfIndex = 0;
            foreach ($request->file('pdfs') as $pdfFile) {
                if ($pdfFile && $pdfFile->isValid()) {
                    $pdfFileName = 'eligibility_criteria_pdf_' . time() . '_' . uniqid() . '.' . $pdfFile->getClientOriginalExtension();
                    $pdfFile->move($destinationPath, $pdfFileName);
                    $pdfPath = 'public/uploads/eligibility_criteria/' . $pdfFileName;
                    $pdfTitle = !empty($pdfTitles[$pdfIndex]) ? $pdfTitles[$pdfIndex] : basename($pdfPath);
                    $pdfs[] = [
                        'path' => $pdfPath,
                        'title' => $pdfTitle
                    ];
                    $pdfIndex++;
                }
            }
        }

        // Store JSON data in description
        $data['description'] = json_encode([
            'description' => $request->input('description'),
            'pdfs' => $pdfs,
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
        
        // Delete all PDF files if exist
        $data = json_decode($content->description, true);
        if ($data && isset($data['pdfs']) && is_array($data['pdfs'])) {
            foreach ($data['pdfs'] as $pdf) {
                // Handle both old format (string) and new format (array)
                $pdfPath = is_array($pdf) ? ($pdf['path'] ?? '') : $pdf;
                if ($pdfPath) {
                    $oldPdfPath = str_replace('public/', '', $pdfPath);
                    if (file_exists(public_path($oldPdfPath))) {
                        unlink(public_path($oldPdfPath));
                    }
                }
            }
        }
        
        $content->delete();

        return redirect()->route('eligibility_criteria_of_college_campus.index')->with('success', 'Eligibility Criteria deleted successfully!');
    }
}

