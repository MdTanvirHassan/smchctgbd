<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdmissionLinksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of admission links
     */
    public function index()
    {
        $admissionLinks = Content::where('type', 'admission_link')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('backend.admission_links.index', compact('admissionLinks'));
    }

    /**
     * Show the form for creating a new admission link
     */
    public function create()
    {
        return view('backend.admission_links.create');
    }

    /**
     * Store newly created admission links (multiple)
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'titles' => 'required|array|min:1',
                'titles.*' => 'required|string|max:255',
                'descriptions' => 'nullable|array',
                'descriptions.*' => 'nullable|string',
                'link_urls' => 'required|array|min:1',
                'link_urls.*' => 'required|url|max:255',
                'start_dates' => 'nullable|array',
                'start_dates.*' => 'nullable|date',
                'end_dates' => 'nullable|array',
                'end_dates.*' => 'nullable|date',
                'is_published' => 'nullable|array',
                'is_published.*' => 'nullable|in:1'
            ]);

            $createdCount = 0;
            $errors = [];

            // Use database transaction
            DB::beginTransaction();

            foreach ($validated['titles'] as $index => $title) {
                try {
                    // Validate end date is after start date for this specific entry
                    $startDate = $validated['start_dates'][$index] ?? null;
                    $endDate = $validated['end_dates'][$index] ?? null;
                    
                    if ($startDate && $endDate && $endDate < $startDate) {
                        $errors[] = "Link #" . ($index + 1) . ": End date must be after start date.";
                        continue;
                    }

                    Content::create([
                        'type' => 'admission_link',
                        'title' => trim($title),
                        'description' => !empty($validated['descriptions'][$index]) ? trim($validated['descriptions'][$index]) : null,
                        'link_url' => trim($validated['link_urls'][$index]),
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                        'is_published' => isset($validated['is_published'][$index]) ? 1 : 0,
                    ]);

                    $createdCount++;
                } catch (\Exception $e) {
                    $errors[] = "Link #" . ($index + 1) . ": " . $e->getMessage();
                }
            }

            if ($createdCount > 0) {
                DB::commit();
                $message = $createdCount === 1 
                    ? 'Admission link created successfully!' 
                    : "{$createdCount} admission links created successfully!";
                
                if (!empty($errors)) {
                    $message .= ' However, some links had errors: ' . implode(', ', $errors);
                }
                
                return redirect()->route('admission_links.index')->with('success', $message);
            } else {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'No links were created. Errors: ' . implode(', ', $errors))
                    ->withInput();
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Admission Links Store Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred while saving. Please try again.')
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified admission link
     */
    public function edit($id)
    {
        $admissionLink = Content::where('type', 'admission_link')->findOrFail($id);
        return view('backend.admission_links.edit', compact('admissionLink'));
    }

    /**
     * Update the specified admission link
     */
    public function update(Request $request, $id)
    {
        try {
            $admissionLink = Content::where('type', 'admission_link')->findOrFail($id);

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'link_url' => 'required|url|max:255',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'is_published' => 'nullable|boolean'
            ]);

            $admissionLink->update([
                'title' => trim($validated['title']),
                'description' => !empty($validated['description']) ? trim($validated['description']) : null,
                'link_url' => trim($validated['link_url']),
                'start_date' => $validated['start_date'] ?? null,
                'end_date' => $validated['end_date'] ?? null,
                'is_published' => $request->has('is_published') ? 1 : 0,
            ]);

            return redirect()->route('admission_links.index')->with('success', 'Admission link updated successfully!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Admission Link Update Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred while updating. Please try again.')
                ->withInput();
        }
    }

    /**
     * Remove the specified admission link
     */
    public function destroy($id)
    {
        try {
            $admissionLink = Content::where('type', 'admission_link')->findOrFail($id);
            $admissionLink->delete();

            return redirect()->route('admission_links.index')->with('success', 'Admission link deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Admission Link Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while deleting. Please try again.');
        }
    }

    /**
     * Toggle the published status of admission link
     */
    public function toggleStatus($id)
    {
        try {
            $admissionLink = Content::where('type', 'admission_link')->findOrFail($id);
            $admissionLink->is_published = !$admissionLink->is_published;
            $admissionLink->save();

            $status = $admissionLink->is_published ? 'published' : 'unpublished';
            return redirect()->back()->with('success', "Admission link {$status} successfully!");
        } catch (\Exception $e) {
            Log::error('Admission Link Status Toggle Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating status.');
        }
    }
}
