<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class landingpageController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'landingpage') {
            return redirect()->route('user.landingpage');
       
        return view('landingpage');
    }
    }
}
