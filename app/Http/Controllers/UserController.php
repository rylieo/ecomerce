<?php

namespace App\Http\Controllers;

use App\Models\User; // Pastikan model User sudah diimport
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Mengambil data pengguna dengan filter pencarian
        $users = User::when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%');
        })
        ->when(request()->input('jenis_kelamin'), function ($query, $jenisKelamin) {
            $query->where('jenis_kelamin', $jenisKelamin);
        })
        ->get();

        return view('users.index', compact('users'));
    }



public function showAdmins()
{
    $admins = User::where('role', 'Admin')->get();
    return view('users.admins', compact('admins'));
}

public function makeAdmin(Request $request)
{
    $user = User::findOrFail($request->user_id);
    $user->role = 'Admin';
    $user->save();

    return redirect()->route('admin.users.admins')->with('success', 'Peran pengguna berhasil diubah menjadi Admin.');
}

public function showAddAdminForm()
{
    $users = User::where('role', 'User')->get();
    return view('users.add_admin', compact('users'));
}

public function removeAdmin($id)
{
    $user = User::findOrFail($id);
    $user->role = 'User'; // Ubah peran menjadi User
    $user->save();

    return redirect()->back()->with('success', 'Peran Admin berhasil dihapus.');
}



}
