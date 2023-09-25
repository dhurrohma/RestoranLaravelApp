<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Kios;
use App\Menu;
use App\User;
use App\Kasir;

class KiosController extends Controller
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
        $kiosQuery = Kios::latest();
        
        $kasir = Kasir::where('user_id', $userId)->first();
        if ($kasir) {
            $kiosQuery->where('id', $kasir->kios_id);
        }

        $dtKios = $kiosQuery->paginate(5);

        return view('Kios.Data-Kios', compact('dtKios', 'userRoles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userId = Auth::user()->id;
        $userRoles = User::find($userId)->role;
        return view('Kios.Create-Kios', compact('userRoles'));
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
            'kios' => 'required',
            'alamat' => 'required',
            'nama_pemilik' => 'required',
            'no_telp' => 'required|digits_between:10,15|numeric',
        ]);

        DB::beginTransaction();

        try {
            $kiosBaru = Kios::create([
                'kios' => $request->kios,
                'alamat' => $request->alamat,
                'nama_pemilik' => $request->nama_pemilik,
                'no_telp' => $request->no_telp
            ]);

            DB::commit();

            return redirect('/kios')->with('toast_success', 'Berhasil Menambah Kios!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('/kios')->with('toast_error', 'Gagal Menambah Kios: ' . $e->getMessage());
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
        $kios = Kios::findorfail($id);
        $userId = Auth::user()->id;
        $userRoles = User::find($userId)->role;
        return view('Kios.Edit-Kios', compact('kios', 'userRoles'));
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
            'kios' => 'required',
            'alamat' => 'required',
            'nama_pemilik' => 'required',
            'no_telp' => 'required|digits_between:10,15|numeric',
        ]);

        DB::beginTransaction();

        try {
            $kios = Kios::findorfail($id);
            
            $kios->update([
                'kios' => $request->kios,
                'alamat' => $request->alamat,
                'nama_pemilik' => $request->nama_pemilik,
                'no_telp' => $request->no_telp
            ]);

            DB::commit();

            return redirect('/kios')->with('toast_success', 'Berhasil Update Kios!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('toast_error', 'Gagal Update Kios: ' . $e->getMessage());
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
        DB::beginTransaction();

        try {
            $kios = Kios::findorfail($id);
            $menu = Menu::where('kios_id', $id);
            
            if($menu->get()->isNotEmpty()) {
                $menu->delete();
            }

            $kios->delete();
            
            DB::commit();

            return back()->with('info', 'Berhasil Menghapus Kios');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('toast_error', 'Gagal Hapus Kios: ' . $e->getMessage());
        }
    }
}
