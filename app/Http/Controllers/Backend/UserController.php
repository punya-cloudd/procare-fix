<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    // Menampilkan data user (DataTables Server Side)
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('users')
                ->leftJoin('m_unit_layanan', 'users.unit_layanan_id', '=', 'm_unit_layanan.id')
                ->select('users.*', 'm_unit_layanan.unit_layanan as unit_layanan')
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $editUrl = route('user.edit', $row->id);
                    $btn = "<a href='$editUrl' class='btn btn-warning btn-sm'><i class='fa fa-edit'></i> </a> ";
                    $btn .= "<button class='btn btn-danger btn-sm btn-delete' data-id='$row->id'><i class='fa fa-trash'></i> </button>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.user.index');
    }

    // Menampilkan form tambah user
    public function create()
    {
        $jenisLayanans = DB::table('m_unit_layanan')->select('id', 'unit_layanan')->get();
        $roles = Role::pluck('name','name')->all();
        return view('backend.user.create', compact('jenisLayanans', 'roles'));
    }

    // Menyimpan data user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'roles.*' => 'required',
            'unit_layanan_id' => 'required|integer',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $photoPath = $request->file('foto')->store('photos', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'unit_layanan_id' => $request->unit_layanan_id,
            'foto' => $fotoPath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $user->assignRole($request->input('roles'));

        return redirect()->route('user.index')->with('success', 'Data user berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::pluck('name', 'id')->mapWithKeys(function ($name, $id) {
            return [(int) $id => $name];
        })->all();

        $userRole = $user->roles->pluck('id')->map(function ($id) {
            return (int) $id;
        })->toArray();

        $jenisLayanans = DB::table('m_unit_layanan')->select('id', 'unit_layanan')->get();

        return view('backend.user.edit', compact('user', 'jenisLayanans', 'roles', 'userRole'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:users,username,' . $id,
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
            'role_id' => 'required',
            'unit_layanan_id' => 'required|integer',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $fotoPath = $request->file('foto')->store('photos', 'public');
        } else {
            $fotoPath = $user->foto;
        }

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
            'role_id' => $request->role_id,
            'unit_layanan_id' => $request->unit_layanan_id,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('user.index')->with('success', 'Data user berhasil diperbarui.');
    }

    // Menghapus data user
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
        }

        $user->delete();

        return response()->json(['success' => true, 'message' => 'Data user berhasil dihapus.']);
    }
}
