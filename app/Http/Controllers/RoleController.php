<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Role;
use App\User;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $userRoles = User::find($userId)->role;
        $dtRole = Role::all();
        return view('Role.Data-Role', compact('dtRole', 'userRoles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Role.Create-Role');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|unique:role'
        ]);

        try {
            $roleBaru = Role::create([
                'role' => $request->role
            ]);

            return redirect('/role')->with('toast_success', 'Berhasil Menambah Role!');
        } catch (\Throwable $th) {
            return redirect('/create-role')->with('toast_error', 'Gagal Menambah Menu: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findorfail($id);
        $userId = Auth::user()->id;
        $userRoles = User::find($userId)->role;

        return view('Role.Edit-Role', compact('role', 'userRoles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|unique:role'
        ]);

        try {
            $role = Role::findorfail($id);

            $role->update([
                'role' => $request->role
            ]);

            return redirect('/role')->with('toast_success', 'Berhasil Update Role!');
        } catch (\Exception $e) {
            return redirect()->back()->with('toast_error', 'Gagal Update Role: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $role = Role::findorfail($id);
            $role->delete();

            return back()->with('info', 'Berhasil Menghapus Role!');
        } catch (\Exception $e) {
            return back()->with('toast_error', 'Gagal Hapus Role: ' . $e->getMessage());
        }
    }
}
