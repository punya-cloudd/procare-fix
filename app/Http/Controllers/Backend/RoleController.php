<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Constructor untuk middleware (opsional).
     */
    function __construct()
    {
        // $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        // $this->middleware('permission:role-create', ['only' => ['create','store']]);
        // $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Menampilkan daftar semua role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::orderBy('id', 'DESC')->paginate(5);
        $permissions = Permission::orderBy('id', 'DESC')->get();

        return view('backend.roles.index', compact('roles', 'permissions'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Menampilkan form untuk membuat role baru.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::get();
        return view('backend.roles.create', compact('permission'));
    }

    /**
     * Menyimpan role baru ke dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|unique:roles,name',
                'permission' => 'required',
            ],
            [
                'name.required' => 'Nama Role tidak boleh kosong!',
                'name.unique' => 'Nama Role sudah ada sebelumnya!',
                'permission.required' => 'Permission tidak boleh kosong!',
            ]
        );

        $role = Role::create(['name' => $request->input('name')]);
        $permissionNames = Permission::whereIn('id', $request->permission)->pluck('name')->toArray();
        $role->syncPermissions($permissionNames);

        return redirect()->route('roles.index')->with('success', 'Role and Permission created successfully');
    }

    /**
     * Menampilkan detail role tertentu.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('backend.roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Menampilkan form untuk mengedit role tertentu.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('backend.roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    /**
     * Memperbarui role tertentu di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate(
            [
                'name' => 'required',
                'permission' => 'required',
            ],
            [
                'name.required' => 'Nama Role tidak boleh kosong!',
                'permission.required' => 'Permission tidak boleh kosong!'
            ]
        );

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        // Sinkronisasi permission
        $permissionNames = Permission::whereIn('id', $request->permission)->pluck('name')->toArray();
        $role->syncPermissions($permissionNames);

        // Redirect dengan pesan sukses
        return redirect()->route('roles.index')->with('success', 'Role dan Permission Berhasil Diperbaruhi');
    }

    /**
     * Menghapus role tertentu dari database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        if ($role) {
            $role->delete();
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error']);
    }    
}
