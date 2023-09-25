<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Transaction;
use App\Menu;
use App\Kios;
use App\Gambar;
use App\Status;
use App\Kasir;
use App\TransactionDetail;
use Carbon\Carbon;
use PDF;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $statuslist = Status::all();
        $userId = Auth::user()->id;
        $userRoles = User::find($userId)->role;
        $kioslist = Kios::all();

        $transactionQuery = Transaction::with('user', 'kios', 'status', 'transactionDetail')->oldest();

        //View untuk Kasir
        $kasir = Kasir::where('user_id', $userId)->first();
        if ($kasir) {
            $transactionQuery->where('kios_id', $kasir->kios_id);
        }
        
        //View untuk Filter
        $selectedStatus = $request->input('status');
        if ($selectedStatus) {
            $transactionQuery->where('status_id', $selectedStatus);
        }

        $selectedKios = $request->input('kios');
        if ($selectedKios) {
            $transactionQuery->where('kios_id', $selectedKios);
        }

        $startDateInput = $request->input('start_datetime');
        if ($startDateInput) {
            $startDate = Carbon::parse($startDateInput)->toDateTimeString();

            $transactionQuery->where('trans_date', '>=', $startDate);
        }

        $endDateInput = $request->input('end_datetime');
        if ($endDateInput) {
            $endDate = Carbon::parse($endDateInput)->toDateTimeString();

            $transactionQuery->where('trans_date', '<=', $endDate);
        }

        $userInput = $request->input('user');
        if ($userInput) {
            $users = User::whereRaw('LOWER(name) like ?', ['%' . strtolower($userInput) . '%'])->pluck('id');
            $transactionQuery->whereIn('user_id', $users);
        }

        $menuInput = $request->input('menu');
        if ($menuInput) {
            $menus = Menu::whereRaw('LOWER(nama_menu) like ?', ['%' . strtolower($menuInput) . '%'])->pluck('id');
            $transD = TransactionDetail::whereIn('menu_id', $menus)->pluck('transaction_id');
            $transactionQuery->whereIn('id', $transD);
        }

        $minPriceInput = $request->input('min_price');
        if ($minPriceInput) {
            $minPrice = preg_replace('/[^0-9]/', '', $minPriceInput);
            $transactionQuery->where('total_price', '>=', $minPrice);
        }

        $maxPriceInput = $request->input('max_price');
        if ($maxPriceInput) {
            $maxPrice = preg_replace('/[^0-9]/', '', $maxPriceInput);
            $transactionQuery->where('total_price', '<=', $maxPrice);
        }

        $transaction = $transactionQuery->paginate(5);

        return view('Transaction.Transaction-Report', compact('transaction', 'statuslist', 'selectedStatus', 'userRoles', 'kioslist', 'selectedKios', 'startDateInput', 'endDateInput', 'userInput', 'menuInput', 'minPriceInput', 'maxPriceInput'));
    }

    public function orderHistory(Request $request)
    {
        $statuslist = Status::all();
        $userId = Auth::user()->id;
        $userRoles = User::find($userId)->role;

        $transactionQuery = Transaction::with('user', 'kios', 'status', 'transactionDetail')->where('user_id', $userId)->latest();

        //View untuk Filter Status
        $selectedStatus = $request->input('status');
        if ($selectedStatus) {
            $transactionQuery->where('status_id', $selectedStatus);
        }

        $transaction = $transactionQuery->paginate(5);

        return view('Transaction.Order-History', compact('transaction', 'statuslist', 'selectedStatus', 'userRoles'));
    }

    public function printReport(Request $request)
    {
        $userId = Auth::user()->id;

        $transactionQuery = Transaction::with('user', 'kios', 'status', 'transactionDetail')->oldest();

        //View untuk Kasir
        $kasir = Kasir::where('user_id', $userId)->first();
        if ($kasir) {
            $transactionQuery->where('kios_id', $kasir->kios_id);
        }

        //View untuk User
        $userRoles = User::find($userId)->role;
        if ($userRoles->count() == 1 && $userRoles->contains(4)) {
            $transactionQuery->where('user_id', $userId);
        }

        //View untuk Filter
        $selectedStatus = $request->input('status');
        if ($selectedStatus) {
            $transactionQuery->where('status_id', $selectedStatus);
        }

        $selectedKios = $request->input('kios');
        if ($selectedKios) {
            $transactionQuery->where('kios_id', $selectedKios);
        }

        $startDateInput = $request->input('start_datetime');
        if ($startDateInput) {
            $startDate = Carbon::parse($startDateInput)->toDateTimeString();

            $transactionQuery->where('trans_date', '>=', $startDate);
        }

        $endDateInput = $request->input('end_datetime');
        if ($endDateInput) {
            $endDate = Carbon::parse($endDateInput)->toDateTimeString();

            $transactionQuery->where('trans_date', '<=', $endDate);
        }

        $userInput = $request->input('user');
        if ($userInput) {
            $users = User::whereRaw('LOWER(name) like ?', ['%' . strtolower($userInput) . '%'])->pluck('id');
            $transactionQuery->whereIn('user_id', $users);
        }

        $menuInput = $request->input('menu');
        if ($menuInput) {
            $menus = Menu::whereRaw('LOWER(nama_menu) like ?', ['%' . strtolower($menuInput) . '%'])->pluck('id');
            $transD = TransactionDetail::whereIn('menu_id', $menus)->pluck('transaction_id');
            $transactionQuery->whereIn('id', $transD);
        }

        $minPriceInput = $request->input('min_price');
        if ($minPriceInput) {
            $minPrice = preg_replace('/[^0-9]/', '', $minPriceInput);
            $transactionQuery->where('total_price', '>=', $minPrice);
        }

        $maxPriceInput = $request->input('max_price');
        if ($maxPriceInput) {
            $maxPrice = preg_replace('/[^0-9]/', '', $maxPriceInput);
            $transactionQuery->where('total_price', '<=', $maxPrice);
        }

        $transaction = $transactionQuery->get();

        $pdf = PDF::loadView('Transaction.Print-Report', compact('transaction', 'selectedStatus', 'userRoles', 'selectedKios', 'startDateInput', 'endDateInput', 'userInput', 'menuInput', 'minPriceInput', 'maxPriceInput'));

        return $pdf->download('transaction-report.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showKios()
    {
        $dtKios = Kios::all();
        $userId = Auth::user()->id;
        $userRoles = User::find($userId)->role;
        return view('Transaction.Select-Kios', compact('dtKios', 'userRoles'));
    }

    public function showMenus($kiosId)
    {
        $kios = Kios::findOrFail($kiosId);
        $menus = $kios->menu;
        $userId = Auth::user()->id;
        $userRoles = User::find($userId)->role;
        return view('Transaction.Select-Menu', compact('kios', 'menus', 'userRoles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePesanan(Request $request)
    {

        DB::beginTransaction();
        
        try {
            // Membuat transaksi baru
            $transaction = new Transaction();
            $transaction->user_id = Auth::id(); // Mendapatkan ID pengguna yang login
            $transaction->trans_date = Carbon::now('Asia/Jakarta');
            $transaction->kios_id = $request->kios_id;
            $transaction->total_price = 0; // Akan dihitung nanti
            $transaction->status_id = 1; // Status 1 mewakili status awal
            $transaction->save();

            // Mengambil data menu
            $menuIds = $request->input('menu_id');
            $quantities = $request->input('quantity');

            // Iterasi melalui item yang dipilih
            foreach ($menuIds as $key => $menuId) {
                // Mendapatkan data menu
                $menu = Menu::findOrFail($menuId);
                $quantity = $quantities[$key];

                if ($quantity > 0) {
                    // Membuat rincian transaksi
                    $transactionDetail = new TransactionDetail();
                    $transactionDetail->transaction_id = $transaction->id;
                    $transactionDetail->menu_id = $menuId;
                    $transactionDetail->quantity = $quantities[$key];
                    $transactionDetail->total_price_item = $menu->harga * $quantities[$key];
                    $transactionDetail->save();
                }
            }

            // Menghitung total_price transaksi setelah semua item selesai dihitung
            $total_price = TransactionDetail::where('transaction_id', $transaction->id)->sum('total_price_item');
            
            if ($total_price > 0) {
                $transaction->total_price = $total_price;

                // Menyimpan total_price yang telah dihitung
                $transaction->save();

                DB::commit();

                // Redirect atau tampilkan pesan sukses
                return view('Transaction.View-Invoice', compact('transaction'))->with('toast_success', 'Pesanan Telah Dibuat');
            } else {
                DB::rollBack();

                return redirect()->back()->with('toast_error', 'Tidak ada menu yang dipesan');
            }
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('toast_error', 'Gagal Membuat Pesanan: ' . $e->getMessage());
        }
        
    }

    public function updateStatus(Request $request)
    {
        $transactionId = $request->input('transactionId');
        $newStatusId = $request->input('newStatusId');

        try {
            DB::beginTransaction();
            $transaction = Transaction::find($transactionId);
            
            if ($transaction) {
                \Log::info("Mengupdate status transaksi ke ID: $transactionId, Status Baru: $newStatusId");

                $transaction->status_id = $newStatusId;
                $transaction->save();
                DB::commit();

                \Log::info("Status transaksi berhasil diperbarui");

                return response()->json(['success' => true]);
            } else {
                DB::rollBack();
                return response()->json(['success' => false]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Terjadi kesalahan saat mengupdate status transaksi: " . $e->getMessage());

            return response()->json(['success' => false]);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function generateInvoice($transactionId)
    {
        $transaction = Transaction::with('user', 'kios', 'status', 'transactionDetail')->find($transactionId);

        if (!$transaction) {
            return abort(404);
        }

        $pdf = PDF::loadView('Transaction.Invoice', compact('transaction'));

        return $pdf->download('invoice-' . $transaction->trans_date . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
