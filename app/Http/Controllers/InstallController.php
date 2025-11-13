<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class InstallController extends Controller
{
    public function showForm()
    {
        return view('install.form');
    }

    public function install(Request $request)
    {
        if (!app()->environment('local')) {
            abort(403, 'Installation is disabled in production.');
        }

        $data = $request->validate([
            'template'         => 'required|string|max:50',
            'email'            => 'required|email',
            'password'         => 'required|min:6',
            'install_password' => 'required|string',
        ]);

        if ($data['install_password'] !== env('INSTALL_PASSWORD')) {
            return back()->withInput()->withErrors([
                'install_password' => 'Invalid installation password.'
            ]);
        }

        Artisan::call('migrate:fresh', ['--force' => true]);

        Artisan::call('db:seed', ['--force' => true]);


        if (User::where('email', $data['email'])->exists()) {
            return back()->withInput()->withErrors([
                'email' => 'Please choose another email.'
            ]);
        }
        User::create([
            'name'     => 'Admin',
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Setting::create([
            'type'  => 'template_name',
            'value' =>  $data['template'],
        ]);

        // In your controller update method:
        Cache::forget('settings');

        
        // --- AUTO SWITCH SESSION DRIVER TO DATABASE ---
        $envPath = base_path('.env');
        if (file_exists($envPath)) {
            file_put_contents(
                $envPath,
                preg_replace(
                    "/^SESSION_DRIVER=.*/m",
                    "SESSION_DRIVER=database",
                    file_get_contents($envPath)
                )
            );
            Artisan::call('config:clear');
        }

        return view('install.success', [
            'template' => $data['template'],
            'email'    => $data['email'],
        ]);
    }

    public function update(Request $request)
    {
        // Only allow in local/dev environment
        if (!app()->environment('local')) {
            abort(403, 'Update is disabled in production.');
        }

        try {
            // Run only pending migrations
            Artisan::call('migrate', [
                '--force' => true, // required to run outside artisan CLI safely
            ]);

            return redirect()->route('login')->with('success', 'System updated successfully. All new migrations applied.');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Update failed: ' . $e->getMessage());
        }
    }
}
