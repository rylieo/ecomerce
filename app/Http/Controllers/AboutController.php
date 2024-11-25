<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\ContactInfo;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
            $abouts = About::all();
            $contacts = ContactInfo::first();
            return view('about', compact('abouts', 'contacts'));
    }
}
