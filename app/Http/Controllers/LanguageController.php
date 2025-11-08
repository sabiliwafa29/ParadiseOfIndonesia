<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch(Request $request)
    {
        $locale = $request->input('locale');
        
        // Validasi locale
        $availableLocales = config('app.available_locales');
        
        if (in_array($locale, $availableLocales)) {
            // Simpan ke session
            Session::put('locale', $locale);
            
            // Jika user login, simpan ke database
            if (auth()->check()) {
                auth()->user()->update(['locale' => $locale]);
            }
        }
        
        return redirect()->back();
    }
}