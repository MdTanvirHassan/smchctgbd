<?php

namespace App\Http\Controllers;

use App\Models\MBBSCOURSECategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class MBBSCOURSEController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the categories
     */
    public function index()
    {
        $categories = MBBSCOURSECategory::getTree();
        return view('backend.mbbs_course.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category
     */
    public function create()
    {
        $parentCategories = MBBSCOURSECategory::getRootCategories();
        return view('backend.mbbs_course.create', compact('parentCategories'));
    }

    /**
     * Store a newly created category with optional child categories
     */
    public function store(Request $request)
    {
        try {
            // Check if table exists
            if (!Schema::hasTable('mbbs_course_categories')) {
                return redirect()->back()
                    ->with('error', 'Database table does not exist! Please run the migration or create the table manually using the provided SQL.')
                    ->withInput();
            }

            $validated = $request->validate([
                'parent_name' => 'required|string|max:255',
                'parent_description' => 'nullable|string',
                'parent_order' => 'nullable|integer|min:0',
                'parent_is_active' => 'nullable',
                'child_names' => 'nullable|array',
                'child_names.*' => 'nullable|string|max:255',
                'child_descriptions' => 'nullable|array',
                'child_descriptions.*' => 'nullable|string',
                'child_orders' => 'nullable|array',
                'child_orders.*' => 'nullable|integer|min:0',
                'child_is_active' => 'nullable|array',
            ]);

            // Use database transaction
            DB::beginTransaction();

            // Create parent category
            $parentSlug = Str::slug($validated['parent_name']);
            $originalSlug = $parentSlug;
            $counter = 1;
            
            // Ensure slug is unique
            while (MBBSCOURSECategory::where('slug', $parentSlug)->exists()) {
                $parentSlug = $originalSlug . '-' . $counter;
                $counter++;
            }

            try {
                $parentCategory = MBBSCOURSECategory::create([
                    'name' => trim($validated['parent_name']),
                    'slug' => $parentSlug,
                    'parent_id' => null,
                    'description' => !empty($validated['parent_description']) ? trim($validated['parent_description']) : null,
                    'order' => isset($validated['parent_order']) ? (int)$validated['parent_order'] : 0,
                    'is_active' => $request->has('parent_is_active') ? 1 : 0,
                ]);
                
                if (!$parentCategory || !$parentCategory->id) {
                    throw new \Exception('Failed to create parent category. Please check database connection and table structure.');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                throw new \Exception('Error creating parent category: ' . $e->getMessage());
            }

            // Create child categories if provided
            $childCount = 0;
            if (!empty($validated['child_names']) && is_array($validated['child_names'])) {
                // Get child_is_active array - checkboxes send values when checked
                $childActiveArray = $request->input('child_is_active', []);
                
                foreach ($validated['child_names'] as $index => $childName) {
                    $childName = trim($childName);
                    if (!empty($childName)) {
                        // Clean child name (remove leading numbers and parentheses if any)
                        $cleanChildName = preg_replace('/^\d+\)\s*/', '', $childName);
                        $cleanChildName = trim($cleanChildName);
                        
                        if (!empty($cleanChildName)) {
                            $childSlug = Str::slug($cleanChildName);
                            $originalChildSlug = $childSlug;
                            $childCounter = 1;
                            
                            // Ensure slug is unique
                            while (MBBSCOURSECategory::where('slug', $childSlug)->exists()) {
                                $childSlug = $originalChildSlug . '-' . $childCounter;
                                $childCounter++;
                            }

                            // Determine if active - checkboxes with name[] send sequential array
                            // Since all are checked by default, default to active (1)
                            // Check if checkbox at this index exists (all should be checked by default)
                            $isActive = 1; // Default all to active since checkboxes are checked by default

                            try {
                                $categoryData = [
                                    'name' => $cleanChildName,
                                    'slug' => $childSlug,
                                    'parent_id' => $parentCategory->id,
                                    'description' => isset($validated['child_descriptions'][$index]) && !empty(trim($validated['child_descriptions'][$index])) ? trim($validated['child_descriptions'][$index]) : null,
                                    'order' => isset($validated['child_orders'][$index]) && $validated['child_orders'][$index] !== '' && $validated['child_orders'][$index] !== null ? (int)$validated['child_orders'][$index] : ($index + 1),
                                    'is_active' => $isActive,
                                ];

                                $childCategory = MBBSCOURSECategory::create($categoryData);
                                
                                if (!$childCategory || !$childCategory->id) {
                                    throw new \Exception('Failed to create child category: ' . $cleanChildName);
                                }
                                
                                $childCount++;
                            } catch (\Exception $e) {
                                throw new \Exception('Error creating child category "' . $cleanChildName . '": ' . $e->getMessage());
                            }
                        }
                    }
                }
            }

            // Commit transaction
            DB::commit();

            $message = $childCount > 0 
                ? "Parent category and {$childCount} child category(ies) created successfully!" 
                : 'Parent category created successfully!';

            return redirect()->route('mbbs-course.index')->with('success', $message);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('MBBS Course Category Store Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred while saving. Please try again. Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified category
     * Only parent categories can be edited with child management
     */
    public function edit($id)
    {
        $category = MBBSCOURSECategory::findOrFail($id);
        
        // If editing a child category, redirect to edit its parent instead
        if ($category->parent_id) {
            return redirect()->route('mbbs-course.edit', $category->parent_id)
                ->with('info', 'Redirected to parent category. Please edit child categories from the parent category form.');
        }
        
        // Load existing child categories for this parent
        $childCategories = $category->children()->orderBy('order', 'asc')->get();
        
        return view('backend.mbbs_course.edit', compact('category', 'childCategories'));
    }

    /**
     * Update the specified parent category with child categories
     */
    public function update(Request $request, $id)
    {
        try {
            // Check if table exists
            if (!Schema::hasTable('mbbs_course_categories')) {
                return redirect()->back()
                    ->with('error', 'Database table does not exist! Please run the migration or create the table manually using the provided SQL.')
                    ->withInput();
            }

            $category = MBBSCOURSECategory::findOrFail($id);
            
            // Only allow editing parent categories (root categories)
            if ($category->parent_id) {
                return redirect()->route('mbbs-course.edit', $category->parent_id)
                    ->with('info', 'Please edit child categories from the parent category form.');
            }

            $validated = $request->validate([
                'parent_name' => 'required|string|max:255',
                'parent_description' => 'nullable|string',
                'parent_order' => 'nullable|integer|min:0',
                'parent_is_active' => 'nullable',
                'child_ids' => 'nullable|array',
                'child_ids.*' => 'nullable|exists:mbbs_course_categories,id',
                'child_names' => 'nullable|array',
                'child_names.*' => 'nullable|string|max:255',
                'child_descriptions' => 'nullable|array',
                'child_descriptions.*' => 'nullable|string',
                'child_orders' => 'nullable|array',
                'child_orders.*' => 'nullable|integer|min:0',
                'child_is_active' => 'nullable|array',
                'delete_children' => 'nullable|array',
                'delete_children.*' => 'nullable|exists:mbbs_course_categories,id',
            ]);

            // Use database transaction
            DB::beginTransaction();

            // Update parent category
            $parentSlug = Str::slug($validated['parent_name']);
            $originalSlug = $parentSlug;
            $counter = 1;
            
            // Ensure slug is unique (excluding current category)
            while (MBBSCOURSECategory::where('slug', $parentSlug)->where('id', '!=', $id)->exists()) {
                $parentSlug = $originalSlug . '-' . $counter;
                $counter++;
            }

            try {
                $category->update([
                    'name' => trim($validated['parent_name']),
                    'slug' => $parentSlug,
                    'parent_id' => null, // Keep as parent
                    'description' => !empty($validated['parent_description']) ? trim($validated['parent_description']) : null,
                    'order' => isset($validated['parent_order']) ? (int)$validated['parent_order'] : 0,
                    'is_active' => $request->has('parent_is_active') ? 1 : 0,
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                throw new \Exception('Error updating parent category: ' . $e->getMessage());
            }

            // Handle child category deletions
            if (!empty($validated['delete_children']) && is_array($validated['delete_children'])) {
                foreach ($validated['delete_children'] as $deleteChildId) {
                    $childToDelete = MBBSCOURSECategory::find($deleteChildId);
                    if ($childToDelete && $childToDelete->parent_id == $id) {
                        $childToDelete->delete();
                    }
                }
            }

            // Get child_is_active array
            $childActiveArray = $request->input('child_is_active', []);
            $childIds = $request->input('child_ids', []);

            // Update existing child categories and create new ones
            $childCount = 0;
            if (!empty($validated['child_names']) && is_array($validated['child_names'])) {
                foreach ($validated['child_names'] as $index => $childName) {
                    $childName = trim($childName);
                    if (!empty($childName)) {
                        // Clean child name (remove leading numbers and parentheses if any)
                        $cleanChildName = preg_replace('/^\d+\)\s*/', '', $childName);
                        $cleanChildName = trim($cleanChildName);
                        
                        if (!empty($cleanChildName)) {
                            $childId = isset($childIds[$index]) && !empty($childIds[$index]) ? $childIds[$index] : null;
                            
                            // Check if this is an existing child category
                            if ($childId && MBBSCOURSECategory::where('id', $childId)->where('parent_id', $id)->exists()) {
                                // Update existing child category
                                $childCategory = MBBSCOURSECategory::find($childId);
                                
                                $childSlug = Str::slug($cleanChildName);
                                $originalChildSlug = $childSlug;
                                $childCounter = 1;
                                
                                // Ensure slug is unique (excluding current child)
                                while (MBBSCOURSECategory::where('slug', $childSlug)->where('id', '!=', $childId)->exists()) {
                                    $childSlug = $originalChildSlug . '-' . $childCounter;
                                    $childCounter++;
                                }

                                $childCategory->update([
                                    'name' => $cleanChildName,
                                    'slug' => $childSlug,
                                    'description' => isset($validated['child_descriptions'][$index]) && !empty(trim($validated['child_descriptions'][$index])) ? trim($validated['child_descriptions'][$index]) : null,
                                    'order' => isset($validated['child_orders'][$index]) && $validated['child_orders'][$index] !== '' && $validated['child_orders'][$index] !== null ? (int)$validated['child_orders'][$index] : ($index + 1),
                                    'is_active' => isset($childActiveArray[$index]) ? 1 : 1,
                                ]);
                                $childCount++;
                            } else {
                                // Create new child category
                                $childSlug = Str::slug($cleanChildName);
                                $originalChildSlug = $childSlug;
                                $childCounter = 1;
                                
                                // Ensure slug is unique
                                while (MBBSCOURSECategory::where('slug', $childSlug)->exists()) {
                                    $childSlug = $originalChildSlug . '-' . $childCounter;
                                    $childCounter++;
                                }

                                try {
                                    $newChildCategory = MBBSCOURSECategory::create([
                                        'name' => $cleanChildName,
                                        'slug' => $childSlug,
                                        'parent_id' => $id,
                                        'description' => isset($validated['child_descriptions'][$index]) && !empty(trim($validated['child_descriptions'][$index])) ? trim($validated['child_descriptions'][$index]) : null,
                                        'order' => isset($validated['child_orders'][$index]) && $validated['child_orders'][$index] !== '' && $validated['child_orders'][$index] !== null ? (int)$validated['child_orders'][$index] : ($index + 1),
                                        'is_active' => isset($childActiveArray[$index]) ? 1 : 1,
                                    ]);
                                    
                                    if (!$newChildCategory || !$newChildCategory->id) {
                                        throw new \Exception('Failed to create child category: ' . $cleanChildName);
                                    }
                                    
                                    $childCount++;
                                } catch (\Exception $e) {
                                    throw new \Exception('Error creating child category "' . $cleanChildName . '": ' . $e->getMessage());
                                }
                            }
                        }
                    }
                }
            }

            // Commit transaction
            DB::commit();

            $message = 'Parent category and ' . $childCount . ' child category(ies) updated successfully!';

            return redirect()->route('mbbs-course.index')->with('success', $message);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('MBBS Course Category Update Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred while updating. Please try again. Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified category
     */
    public function destroy($id)
    {
        $category = MBBSCOURSECategory::findOrFail($id);

        // Check if category has children
        if ($category->hasChildren()) {
            return redirect()->back()->with('error', 'Cannot delete category with child categories! Please delete child categories first.');
        }

        $category->delete();

        return redirect()->route('mbbs-course.index')->with('success', 'Category deleted successfully!');
    }
}

