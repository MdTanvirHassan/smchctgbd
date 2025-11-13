<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Setting;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

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
        // Always load fresh from database (no cache) to show latest saved values
        Cache::forget('business_settings');
        $settings = Setting::all()->pluck('value', 'type');
        return view('backend.setting.site_setting', compact('settings'));
    }
    public function site_setting_update(Request $request)
    {
        $types = $request->input('types', []);

        foreach ($types as $type) {
            $removeRequested = filter_var($request->input($type . '_remove'), FILTER_VALIDATE_BOOLEAN);
            if ($removeRequested) {
                $existingSetting = Setting::where('type', $type)->first();
                if ($existingSetting && $existingSetting->value) {
                    $oldFilePath = public_path(str_replace('public/', '', $existingSetting->value));
                    if (File::exists($oldFilePath)) {
                        File::delete($oldFilePath);
                    }
                }

                Setting::updateOrCreate(
                    ['type' => $type],
                    ['value' => null]
                );
                continue;
            }

            if ($request->hasFile($type . '_file')) {
                // Find existing setting to delete old file if exists
                $existingSetting = Setting::where('type', $type)->first();

                if ($existingSetting && $existingSetting->value) {
                    $oldFilePath = public_path(str_replace('public/', '', $existingSetting->value));
                    if (File::exists($oldFilePath)) {
                        File::delete($oldFilePath);
                    }
                }

                $file = $request->file($type . '_file');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // Move file to public/assets/img/settings (inside Laravel's public folder)
                $destinationPath = public_path('assets/img/settings');
                if (!File::isDirectory($destinationPath)) {
                    File::makeDirectory($destinationPath, 0777, true);
                }
                $file->move($destinationPath, $fileName);

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

        // Clear all relevant caches
        Cache::forget('business_settings');
        Cache::forget('settings');

        // Force fresh data reload by redirecting with timestamp
        return redirect()->route('site.setting')->with('success', 'Settings updated successfully!');
    }









    public function seo_setting()
    {
        return view('backend.setting.seo_setting');
    }
    public function seo_setting_update(Request $request)
    {
        $types = $request->input('types', []);

        foreach ($types as $type) {
            $removeRequested = filter_var($request->input($type . '_remove'), FILTER_VALIDATE_BOOLEAN);
            if ($removeRequested) {
                $existingSetting = Setting::where('type', $type)->first();
                if ($existingSetting && $existingSetting->value) {
                    $oldFilePath = public_path(str_replace('public/', '', $existingSetting->value));
                    if (File::exists($oldFilePath)) {
                        File::delete($oldFilePath);
                    }
                }

                Setting::updateOrCreate(
                    ['type' => $type],
                    ['value' => null]
                );
                continue;
            }

            // Handle file uploads for image fields
            if ($request->hasFile($type . '_file')) {
                // Find existing setting to delete old file if exists
                $existingSetting = Setting::where('type', $type)->first();

                if ($existingSetting && $existingSetting->value) {
                    $oldFilePath = public_path(str_replace('public/', '', $existingSetting->value));
                    if (File::exists($oldFilePath)) {
                        File::delete($oldFilePath);
                    }
                }

                $file = $request->file($type . '_file');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // Save file to public/assets/img/seo (or any folder you like)
                $destinationPath = public_path('assets/img/settings');
                if (!File::isDirectory($destinationPath)) {
                    File::makeDirectory($destinationPath, 0777, true);
                }
                $file->move($destinationPath, $fileName);

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
        Cache::forget('business_settings');

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
            $removeRequested = filter_var($request->input($type . '_remove'), FILTER_VALIDATE_BOOLEAN);
            if ($removeRequested) {
                $existingSetting = Setting::where('type', $type)->first();
                if ($existingSetting && $existingSetting->value) {
                    $oldFilePath = public_path(str_replace('public/', '', $existingSetting->value));
                    if (File::exists($oldFilePath)) {
                        File::delete($oldFilePath);
                    }
                }

                Setting::updateOrCreate(
                    ['type' => $type],
                    ['value' => null]
                );
                continue;
            }

            // Check if it's a file upload
            if ($request->hasFile($type . '_file')) {
                $file = $request->file($type . '_file');

                // Find old file for deletion
                $existingSetting = Setting::where('type', $type)->first();
                if ($existingSetting && $existingSetting->value) {
                    $oldFilePath = public_path(str_replace('public/', '', $existingSetting->value));
                    if (File::exists($oldFilePath)) {
                        File::delete($oldFilePath);
                    }
                }

                // Generate new file name
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('assets/img/settings');
                if (!File::isDirectory($destinationPath)) {
                    File::makeDirectory($destinationPath, 0777, true);
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
        Cache::forget('business_settings');

        return redirect()->back()->with('success', 'Homepage content updated successfully.');
    }
}
