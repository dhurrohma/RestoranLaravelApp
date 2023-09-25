<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Menu;
use App\Kios;
use App\Gambar;
use App\User;
use App\Kasir;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = Auth::user()->id;
        $userRoles = User::find($userId)->role;
        $kioslist = Kios::all();
        $menuQuery = Menu::with('kios', 'gambar')->latest();
        
        $kasir = Kasir::where('user_id', $userId)->first();
        if ($kasir) {
            $menuQuery->where('kios_id', $kasir->kios_id);
        }

        $selectedKios = $request->input('kios');
        if ($selectedKios) {
            $menuQuery->where('kios_id', $selectedKios);
        }
        
        $dtMenu = $menuQuery->paginate(5);

        return view('Menu.Data-Menu', compact('dtMenu', 'userRoles', 'kioslist', 'selectedKios'));
    }

    public function print()
    {
        $dtPrintMenu = Menu::with('kios')->get();
        return view('Menu.Print-Menu', compact('dtPrintMenu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kios = Kios::all();
        $userId = Auth::user()->id;
        $userRoles = User::find($userId)->role;
        return view('Menu.Create-Menu', compact('kios', 'userRoles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        $kasir = Kasir::where('user_id', $userId)->first();

        $request->validate([
            'kios_id' => $kasir ? 'nullable' : 'required',
            'nama' => 'required',
            'jenis' => 'required', 
            'harga' => 'required', 
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        DB::beginTransaction();

        try {
            $menuBaru = Menu::create([
                'kios_id' => $kasir ? $kasir->kios_id : $request->kios_id,
                'nama_menu' => $request->nama,
                'jenis' => $request->jenis, 
                'harga' => preg_replace('/[^0-9]/', '', $request->harga), 
                'deskripsi' => $request->deskripsi
            ]);

            if ($request->hasFile('gambar')) {
                $gambar = $request->file('gambar');
                $tanggalWaktu = date('YmdHis');
                $namaFile = $tanggalWaktu . ".jpg";
                $dtUpload = new Gambar;
                $dtUpload->id_menu = $menuBaru->id;
                $dtUpload->gambar = $namaFile;

                $gambar->move(public_path().'/Image', $namaFile);

                $dtUpload->save();
            }

            DB::commit();

            return redirect('/menu')->with('toast_success', 'Berhasil Menambah Menu!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('/menu')->with('toast_error', 'Gagal Menambah Menu: ' . $e->getMessage());
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($kiosId)
    {
        $kios = Kios::findOrFail($kiosId);
        $menus = $kios->menu;
        return view('kios.menus', compact('kios', 'menus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kios = Kios::all();
        $gambar = Gambar::where('id_menu', $id)->first();
        $menu = Menu::with('kios', 'gambar')->findorfail($id);
        $hargaFormat = number_format($menu->harga, 0, ',', '.');
        $userId = Auth::user()->id;
        $userRoles = User::find($userId)->role;

        return view('Menu.Edit-Menu', compact('menu', 'kios', 'gambar', 'userRoles', 'hargaFormat'));
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
            'kios_id' => 'required',
            'nama_menu' => 'required',
            'jenis' => 'required', 
            'harga' => 'required', 
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        DB::beginTransaction();

        try {
            $menu = Menu::findorfail($id);

            $menu->update([
                'kios_id' => $request->kios_id,
                'nama_menu' => $request->nama_menu,
                'jenis' => $request->jenis,
                'harga' => preg_replace('/[^0-9]/', '', $request->harga),
                'deskripsi' => $request->deskripsi,
            ]);

            if ($request->hasFile('gambar')) {
                $ubah = Gambar::where('id_menu', $id)->first();
            
                $tanggal = date('YmdHis');
                $namaFile = $tanggal . ".jpg";

                $dt = [
                    'id_menu' => $id,
                    'gambar' => $namaFile,
                ];

                $request->gambar->move(public_path().'/Image', $namaFile);

                if($ubah){
                    $file = public_path('/Image/').$ubah->gambar;

                    $ubah->update($dt);

                    if (file_exists($file)) {
                        @unlink($file);
                    }
                } else {
                    Gambar::create($dt);
                }
            
            }

            DB::commit();

            return redirect('/menu')->with('toast_success', 'Berhasil Update Menu!');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->with('toast_error', 'Gagal Update Menu: ' . $e->getMessage());
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
            $menu = Menu::findorfail($id);

            $gambar = Gambar::where('id_menu', $id)->first();

            if ($gambar) {
                $file = public_path('/Image/').$gambar->gambar;

                $gambar->delete();

                if (file_exists($file)) {
                    @unlink($file);
                }
            }

            $menu->delete();

            DB::commit();

            return back()->with('info', 'Berhasil Menghapus Menu!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('toast_error', 'Gagal Hapus Menu: ' . $e->getMessage());
        }

        
    }
}
