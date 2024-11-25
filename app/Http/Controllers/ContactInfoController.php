<?php

namespace App\Http\Controllers;

use App\Models\ContactInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactInfoController extends Controller
{
    public function index()
    {
        $contacts = ContactInfo::first();
        return view('contact.index', compact('contacts'));
    }

    public function create()
    {
        return view('contact.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:contact_info,email',
            'phone' => 'required|unique:contact_info,phone',
        ]);

        ContactInfo::create($request->all());
        return redirect()->route('contacts.index')->with('success', 'Contact info created successfully.');
    }

    public function edit($id)
    {
        $contact = ContactInfo::findOrFail($id);
        return view('contact.edit', compact('contact'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|unique:contact_info,email,' . $id,
            'phone' => 'required|unique:contact_info,phone,' . $id,
        ]);

        $contact = ContactInfo::findOrFail($id);
        $contact->update($request->all());
        return redirect()->route('contacts.index')->with('success', 'Contact info updated successfully.');
    }

    public function destroy($id)
    {
        $contact = ContactInfo::findOrFail($id);
        $contact->delete();
        return redirect()->route('contacts.index')->with('success', 'Contact info deleted successfully.');
    }
}
