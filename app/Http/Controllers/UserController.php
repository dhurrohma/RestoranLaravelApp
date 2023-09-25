<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Kios;
use App\Role;
use App\Kasir;

class UserController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $userRoles = User::find($userId)->role;
        $dtUser = User::latest()->paginate(5);
        return view('User.Data-User', compact('dtUser', 'userRoles'));
    }

    public function edit($id)
    {
        $user = User::findorfail($id);

        $role = Role::all();

        $userRole = $user->role->pluck('id')->toArray();

        $kiosOptions = Kios::all();

        $userId = Auth::user()->id;
        $userRoles = User::find($userId)->role;

        return view('User.Edit-User', compact('user', 'role', 'userRole', 'kiosOptions', 'userRoles'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            // Temukan pengguna yang akan diperbarui
            $user = User::findOrFail($id);

            $this->validate($request, [
                'role' => [
                    'required',
                    'array',
                    'min:1',
                    
                ],
            ]);
    
            // Perbarui data pengguna lainnya
            $user->update($request->except('role'));
    
            // Ambil peran yang dipilih dari input checkbox
            $selectedRoles = $request->input('role', []);
    
            // Ambil peran yang sudah ada dalam tabel user_role
            $existingRoles = $user->role->pluck('id')->toArray();
    
            // Periksa setiap peran yang dipilih
            foreach ($selectedRoles as $roleId) {
                // Jika peran tidak ada dalam tabel user_role, buat data baru
                if (!in_array($roleId, $existingRoles)) {
                    $user->role()->attach($roleId);
                }
            }
    
            // Hapus peran yang tidak dipilih
            foreach ($existingRoles as $roleId) {
                // Jika peran tidak dipilih dalam checkbox, hapus dari user_role
                if (!in_array($roleId, $selectedRoles)) {
                    $user->role()->detach($roleId);
                }
            }

            if ($request->filled('kios_id')) {
                // Jika kios_id ada dalam formulir, cek apakah ID tersebut ada dalam user_id di tabel kasir
                $kasir = Kasir::where('user_id', $user->id)->first();
                if ($kasir) {
                    // Jika ditemukan, perbarui kios_id
                    $kasir->update(['kios_id' => $request->input('kios_id')]);
                } else {
                    // Jika tidak ditemukan, buat data kasir baru
                    Kasir::create([
                        'user_id' => $user->id,
                        'kios_id' => $request->input('kios_id'),
                    ]);
                }
            } else {
                // Jika kios_id tidak ada dalam formulir, hapus data dari tabel kasir jika ada
                $kasir = Kasir::where('user_id', $user->id)->first();
                if ($kasir) {
                    $kasir->delete();
                }
            }

            DB::commit();
    
            return redirect('/user')->with('toast_success', 'Berhasil Ubah Role User!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('toast_error', 'Gagal Ubah Role User: ' . $e->getMessage());
        }
        
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);

            DB::table('user-role')->where('user_id', $user->id)->delete();

            $user->delete();

            DB::commit();

            return back()->with('info', 'Berhasil Menghapus User!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('toast_error', 'Gagal Hapus User: ' . $e->getMessage());
        }
    }
}
