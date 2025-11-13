<?php

namespace App\Http\Controllers;

use App\Models\GalleryCategory;
use App\Models\GalleryImage;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class GalleryImageController extends Controller
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

    // Gallery Category Page  
    public function gallerycategory()
    {
        $gallerycategorys = GalleryCategory::get();
        return view('backend.gallery.gallerycategory', compact('gallerycategorys'));
    }

    public function gallerycategoryStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $gallerycategory = GalleryCategory::where('name', $validated['name'])->first();
        if ($gallerycategory) {
            return redirect()->back()->with('error', 'Gallery Category with this name already exists.');
        }

        $thumbnail_path = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $fileName = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('assets/img/gallery'), $fileName);
            $thumbnail_path = 'public/assets/img/gallery/' . $fileName;
        }

        GalleryCategory::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'thumbnail_path' => $thumbnail_path,
        ]);

        return redirect()->route('gallerycategory.index')->with('success', 'Gallery Category added successfully!');
    }

    public function gallerycategoryEdit($id)
    {
        $gallerycategory = GalleryCategory::findOrFail($id);
        return view('backend.gallery.gallerycategory-edit', compact('gallerycategory'));
    }

    public function gallerycategoryUpdate(Request $request, $id)
    {
        $gallerycategory = GalleryCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 🔹 Use a different variable for uniqueness check
        $exists = GalleryCategory::where('name', $validated['name'])
            ->where('id', '!=', $id)   // Exclude the current category
            ->first();

        if ($exists) {
            return redirect()->back()->with('error', 'Gallery Category with this name already exists.');
        }

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            $oldPhotoPath = public_path(str_replace('public/', '', $gallerycategory->thumbnail_path));
            if ($gallerycategory->thumbnail_path && file_exists($oldPhotoPath)) {
                unlink($oldPhotoPath);
            }

            $photo = $request->file('photo');
            $fileName = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('assets/img/gallery'), $fileName);
            $thumbnail_path = 'public/assets/img/gallery/' . $fileName;
        } else {
            $thumbnail_path = $gallerycategory->thumbnail_path;
        }

        $gallerycategory->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'thumbnail_path' => $thumbnail_path,
        ]);

        return redirect()->route('gallerycategory.index')->with('success', 'Gallery Category updated successfully!');
    }

    public function gallerycategoryDestroy($id)
    {
        $gallerycategory = GalleryCategory::findOrFail($id);

        if ($gallerycategory->thumbnail_path) {
            $photoPath = public_path(str_replace('public/', '', $gallerycategory->thumbnail_path));
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

        $gallerycategory->delete();

        return redirect()->back()->with('error', 'Gallery Category deleted successfully.');
    }


    // Gallery mage Page  
    // Show paginated gallery images list with categories

    public function galleryimage()
    {
        $galleryimages = GalleryImage::get();
        $gallerycategories = GalleryCategory::all();
        return view('backend.gallery.galleryimage', compact('galleryimages', 'gallerycategories'));
    }

    public function galleryimageStore(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|integer',
            'title' => 'required|string|max:100',
            'caption' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean'
        ]);

        $file_path = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $fileName = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('assets/img/gallery'), $fileName);
            // store path without "public/"
            $file_path = 'public/assets/img/gallery/' . $fileName;
        }

        GalleryImage::create([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'caption' => $validated['caption'],
            'file_path' => $file_path,
            'is_active' => $validated['is_active'] ?? 0
        ]);

        return redirect()->route('galleryimage.index')->with('success', 'Gallery Image added successfully!');
    }

    public function galleryimageEdit($id)
    {
        $galleryimage = GalleryImage::findOrFail($id);
        return view('backend.gallery.galleryimage-edit', compact('galleryimage'));
    }

    public function galleryimageUpdate(Request $request, $id)
    {
        $galleryimage = GalleryImage::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required|integer',
            'title' => 'required|string|max:100',
            'caption' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'nullable|boolean'
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            $oldPhotoPath = public_path($galleryimage->file_path);
            if ($galleryimage->file_path && file_exists($oldPhotoPath)) {
                unlink($oldPhotoPath);
            }

            $photo = $request->file('photo');
            $fileName = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('assets/img/gallery'), $fileName);
            $file_path = 'public/assets/img/gallery/' . $fileName;
        } else {
            $file_path = $galleryimage->file_path;
        }

        $galleryimage->update([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'caption' => $validated['caption'],
            'file_path' => $file_path,
            'is_active' => $validated['is_active'] ?? 0
        ]);

        return redirect()->route('galleryimage.index')->with('success', 'Gallery Image updated successfully!');
    }

    public function galleryimageDestroy($id)
    {
        $galleryimage = GalleryImage::findOrFail($id);

        if ($galleryimage->file_path) {
            $photoPath = public_path($galleryimage->file_path);
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
        }

        $galleryimage->delete();

        return redirect()->back()->with('error', 'Gallery Image deleted successfully.');
    }


}
