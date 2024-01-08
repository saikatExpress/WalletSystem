<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class TestController extends Controller
{
    public function languageUpdate(Request $request)
    {
        $lang = $request->input('lang');

        if (in_array($lang, config('app.locales'))) {
            session(['locale' => $lang]);
        }

        return redirect()->back();
    }
}
