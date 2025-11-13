<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Schema;

class CheckInstallation
{
    public function handle($request, Closure $next)
    {
      
        try { 
            // Check if "sessions" table exists
            if (!Schema::hasTable('sessions')) {
                // Only redirect if not already on install/update
                if (!$request->is('install*') && !$request->is('update*')) {
                    return redirect()->route('showform');
                }
            }
        } catch (\Exception $e) {
            // DB connection issue → redirect to installer
            if (!$request->is('install*') && !$request->is('update*')) {
                return redirect('/install');
            }
        }

        return $next($request);
    }
}
