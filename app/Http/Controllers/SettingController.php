<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Setting;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function site_setting()
    {
        return view('backend.setting.site_setting');
    }
    public function site_setting_update(Request $request)
    {
        $types = $request->input('types', []);

        foreach ($types as $type) {
            if ($request->hasFile($type . '_file')) {
                // Find existing setting to delete old file if exists
                $existingSetting = Setting::where('type', $type)->first();

                if ($existingSetting && $existingSetting->value) {
                    $oldFilePath = public_path(str_replace('public/', '', $existingSetting->value));
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file = $request->file($type . '_file');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // Move file to public/assets/img/settings (inside Laravel's public folder)
                $file->move(public_path('assets/img/settings'), $fileName);

                // Store path with 'public/' prefix in DB (as per your project convention)
                $value = 'public/assets/img/settings/' . $fileName;
            } else {
                // Get normal input value
                $value = $request->input($type);
                if (is_array($value)) {
                    $value = json_encode($value);
                }
            }

            Setting::updateOrCreate(
                ['type' => $type],
                ['value' => $value]
            );
        }

        // In your controller update method:
        Cache::forget('settings');

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }









    public function seo_setting()
    {
        return view('backend.setting.seo_setting');
    }
    public function seo_setting_update(Request $request)
    {
        $types = $request->input('types', []);

        foreach ($types as $type) {
            // Handle file uploads for image fields
            if ($request->hasFile($type . '_file')) {
                // Find existing setting to delete old file if exists
                $existingSetting = Setting::where('type', $type)->first();

                if ($existingSetting && $existingSetting->value) {
                    $oldFilePath = public_path(str_replace('public/', '', $existingSetting->value));
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file = $request->file($type . '_file');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // Save file to public/assets/img/seo (or any folder you like)
                $file->move(public_path('assets/img/settings'), $fileName);

                // Store relative path in DB, e.g. 'assets/img/seo/filename.jpg'
                $value = 'public/assets/img/settings/' . $fileName;
            } else {
                // Handle regular text input fields
                $value = $request->input($type);
                if (is_array($value)) {
                    $value = json_encode($value);
                }
            }

            Setting::updateOrCreate(
                ['type' => $type],
                ['value' => $value]
            );
        }

        // Clear settings cache if used
        Cache::forget('settings');

        return redirect()->back()->with('success', 'SEO settings updated successfully!');
    }




    public function appearence_setting()
    {
        return view('backend.setting.appearence');
    }
    public function appearence_setting_update(Request $request)
    {
        $types = $request->input('types', []);

        foreach ($types as $type) {
            // Check if it's a file upload
            if ($request->hasFile($type . '_file')) {
                $file = $request->file($type . '_file');

                // Find old file for deletion
                $existingSetting = Setting::where('type', $type)->first();
                if ($existingSetting && $existingSetting->value) {
                    $oldFilePath = public_path(str_replace('public/', '', $existingSetting->value));
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                // Generate new file name
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('assets/img/settings');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                // Move file
                $file->move($destinationPath, $fileName);

                // Save path in DB
                $value = 'public/assets/img/settings/' . $fileName;
            } else {
                // Handle regular inputs
                $value = $request->input($type);
                if (is_array($value)) {
                    $value = json_encode($value);
                }
            }

            // Save or update
            Setting::updateOrCreate(
                ['type' => $type],
                ['value' => $value]
            );
        }

        // Clear cache
        Cache::forget('settings');

        return redirect()->back()->with('success', 'Homepage content updated successfully.');
    }
}
