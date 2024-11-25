<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;


class AddressController extends Controller
{
    public function update(Request $request, $id)
        {
            $request->validate([
                'address' => 'required|string|max:255',
            ]);

            $address = Address::findOrFail($id);
            $address->update(['address' => $request->address]);

            return redirect()->back()->with('success', 'Alamat berhasil diperbarui!');
        }

}
