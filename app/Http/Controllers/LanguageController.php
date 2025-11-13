<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Update the application locale for the current user session.
     */
    public function switch(string $locale, Request $request): RedirectResponse
    {
        $availableLocales = ['en', 'bn'];

        if (! in_array($locale, $availableLocales, true)) {
            $locale = config('app.locale');
        }

        Session::put('locale', $locale);
        App::setLocale($locale);

        return redirect()->back();
    }
}

