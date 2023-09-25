<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Gambar;
use App\Menu;
use App\User;

class UploadgambarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $dataGambar = Gambar::with('menu')->latest()->paginate(5);
        // return view('UploadGambar.Data-Gambar', compact('dataGambar'));

        $userId = Auth::user()->id;
        $userRoles = User::find($userId)->role;
        $dtGambar = Gambar::with('menu')->latest()->paginate(5);
        return view('UploadGambar.Data-Gambar', compact('dtGambar', 'userRoles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menu = Menu::all();
        $userId = Auth::user()->id;
        $userRoles = User::find($userId)->role;
        return view('UploadGambar.Create-Gambar', compact('menu', 'userRoles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());

        $nm = $request->gambar;
        $tanggalWaktu = date('YmdHis');
        $namaFile = $tanggalWaktu . ".jpg";

        $dtUpload = new Gambar;
        $dtUpload->id_menu = $request->id_menu;
        $dtUpload->gambar = $namaFile;

        $nm->move(public_path().'/Image', $namaFile);
        $dtUpload->save();

        return redirect('gambar')->with('toast_success', 'Berhasil Upload Gambar!');
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
        $menu = Menu::all();
        $dt = Gambar::with('menu')->findorfail($id);
        $userId = Auth::user()->id;
        $userRoles = User::find($userId)->role;
        return view('UploadGambar.Edit-Gambar', compact('dt', 'menu', 'userRoles'));
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

        $ubah = Gambar::findorfail($id);
        $file = public_path('/Image/').$ubah->gambar;

        $tanggalWaktu = date('YmdHis');
        $namaFile = $tanggalWaktu . ".jpg";

        $dt = [
            'id_menu' => $request['id_menu'],
            'gambar' => $namaFile,
        ];

        $request->gambar->move(public_path().'/Image', $namaFile);
        $ubah->update($dt);

        if (file_exists($file)) {
            @unlink($file);
        }

        return redirect('gambar')->with('toast_success', 'Berhasil Ubah Gambar!');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hapus = Gambar::findorfail($id);

        $file = public_path('/Image/').$hapus->gambar;

        $hapus->delete();

        if (file_exists($file)) {
            @unlink($file);
        }

        return back()->with('info', 'Berhasil Menghapus Gambar!');
    }
}
