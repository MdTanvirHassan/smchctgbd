<?php

namespace App\Http\Controllers;

use App\Models\VideoGalleryCategory;
use App\Models\VideoGallery;
use Illuminate\Http\Request;

class VideoGalleryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Video Gallery Category Page  
    public function videogallerycategory()
    {
        $videogallerycategorys = VideoGalleryCategory::get();
        return view('backend.gallery.videogallerycategory', compact('videogallerycategorys'));
    }

    public function videogallerycategoryStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $videogallerycategory = VideoGalleryCategory::where('name', $validated['name'])->first();
        if ($videogallerycategory) {
            return redirect()->back()->with('error', 'Video Gallery Category with this name already exists.');
        }

        $thumbnail_path = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $fileName = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('assets/video/gallery'), $fileName);
            $thumbnail_path = 'public/assets/video/gallery/' . $fileName;
        }

        VideoGalleryCategory::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'thumbnail_path' => $thumbnail_path,
        ]);

        return redirect()->route('videogallerycategory.index')->with('success', 'Video Gallery Category added successfully!');
    }

    public function videogallerycategoryUpdate(Request $request, $id)
    {
        $videogallerycategory = VideoGalleryCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 🔹 Use a different variable for uniqueness check
        $exists = VideoGalleryCategory::where('name', $validated['name'])
            ->where('id', '!=', $id)   // Exclude the current category
            ->first();

        if ($exists) {
            return redirect()->back()->with('error', 'Video Gallery Category with this name already exists.');
        }

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            $oldPhotoPath = public_path(str_replace('public/', '', $videogallerycategory->thumbnail_path));
            if ($videogallerycategory->thumbnail_path && file_exists($oldPhotoPath)) {
                unlink($oldPhotoPath);
            }

            $photo = $request->file('photo');
            $fileName = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('assets/video/gallery'), $fileName);
            $thumbnail_path = 'public/assets/video/gallery/' . $fileName;
        } else {
            $thumbnail_path = $videogallerycategory->thumbnail_path;
        }

        $videogallerycategory->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'thumbnail_path' => $thumbnail_path,
        ]);

        return redirect()->route('videogallerycategory.index')->with('success', 'Video Gallery Category updated successfully!');
    }

    public function videogallerycategoryDestroy($id)
    {
        $videogallerycategory = VideoGalleryCategory::findOrFail($id);

        if ($videogallerycategory->thumbnail_path) {
            $photoPath = public_path(str_replace('public/', '', $videogallerycategory->thumbnail_path));
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

        $videogallerycategory->delete();

        return redirect()->back()->with('error', 'Video Gallery Category deleted successfully.');
    }


    // Video Gallery Page  
    public function videogallery()
    {
        $videogallerys = VideoGallery::get();
        $videogallerycategories = VideoGalleryCategory::all();
        return view('backend.gallery.videogallery', compact('videogallerys', 'videogallerycategories'));
    }

    public function videogalleryStore(Request $request)
    {
        $rules = [
            'category_id' => 'required|integer',
            'title' => 'required|string|max:100',
            'caption' => 'nullable|string|max:255',
            'video_type' => 'required|in:upload,url',
            'is_active' => 'nullable|boolean'
        ];

        // Conditional validation based on video_type
        if ($request->input('video_type') === 'upload') {
            $rules['video'] = 'required|mimes:mp4,avi,mov,wmv,flv,webm|max:102400'; // 100MB max
        } else {
            $rules['video_url'] = 'required|url|max:500';
        }

        $validated = $request->validate($rules);

        $video_path = null;
        $video_url = null;

        if ($request->input('video_type') === 'upload' && $request->hasFile('video')) {
            $video = $request->file('video');
            $fileName = time() . '_' . uniqid() . '.' . $video->getClientOriginalExtension();
            
            // Create directory if it doesn't exist
            $destinationPath = public_path('assets/video/gallery');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            $video->move($destinationPath, $fileName);
            $video_path = 'public/assets/video/gallery/' . $fileName;
        } elseif ($request->input('video_type') === 'url' && $request->filled('video_url')) {
            $video_url = $request->input('video_url');
        }

        VideoGallery::create([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'caption' => $validated['caption'],
            'video_path' => $video_path,
            'video_url' => $video_url,
            'is_active' => $validated['is_active'] ?? 0
        ]);

        return redirect()->route('videogallery.index')->with('success', 'Video Gallery added successfully!');
    }

    public function videogalleryUpdate(Request $request, $id)
    {
        $videogallery = VideoGallery::findOrFail($id);

        $rules = [
            'category_id' => 'required|integer',
            'title' => 'required|string|max:100',
            'caption' => 'nullable|string|max:255',
            'video_type' => 'required|in:upload,url',
            'is_active' => 'nullable|boolean'
        ];

        // Conditional validation based on video_type
        if ($request->input('video_type') === 'upload') {
            // Only require video if switching from URL to upload, or if no existing video_path
            if (empty($videogallery->video_path)) {
                $rules['video'] = 'required|mimes:mp4,avi,mov,wmv,flv,webm|max:102400'; // 100MB max
            } else {
                $rules['video'] = 'nullable|mimes:mp4,avi,mov,wmv,flv,webm|max:102400'; // 100MB max
            }
        } else {
            $rules['video_url'] = 'required|url|max:500';
        }

        $validated = $request->validate($rules);

        $video_path = $videogallery->video_path;
        $video_url = $videogallery->video_url;

        if ($request->input('video_type') === 'upload') {
            // Clear video_url if switching to upload
            $video_url = null;
            
            if ($request->hasFile('video')) {
                // Delete old video if exists
                if ($videogallery->video_path) {
                    $oldVideoPath = public_path(str_replace('public/', '', $videogallery->video_path));
                    if (file_exists($oldVideoPath)) {
                        unlink($oldVideoPath);
                    }
                }

                $video = $request->file('video');
                $fileName = time() . '_' . uniqid() . '.' . $video->getClientOriginalExtension();
                
                // Create directory if it doesn't exist
                $destinationPath = public_path('assets/video/gallery');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                
                $video->move($destinationPath, $fileName);
                $video_path = 'public/assets/video/gallery/' . $fileName;
            }
            // If no new file uploaded but type is upload, keep existing video_path
        } elseif ($request->input('video_type') === 'url') {
            // Clear video_path if switching to URL
            if ($videogallery->video_path) {
                $oldVideoPath = public_path(str_replace('public/', '', $videogallery->video_path));
                if (file_exists($oldVideoPath)) {
                    unlink($oldVideoPath);
                }
            }
            $video_path = null;
            $video_url = $request->input('video_url');
        }

        $videogallery->update([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'caption' => $validated['caption'],
            'video_path' => $video_path,
            'video_url' => $video_url,
            'is_active' => $validated['is_active'] ?? 0
        ]);

        return redirect()->route('videogallery.index')->with('success', 'Video Gallery updated successfully!');
    }

    public function videogalleryDestroy($id)
    {
        $videogallery = VideoGallery::findOrFail($id);

        if ($videogallery->video_path) {
            $videoPath = public_path(str_replace('public/', '', $videogallery->video_path));
            if (file_exists($videoPath)) {
                unlink($videoPath);
            }
        }

        $videogallery->delete();

        return redirect()->back()->with('error', 'Video Gallery deleted successfully.');
    }

}

