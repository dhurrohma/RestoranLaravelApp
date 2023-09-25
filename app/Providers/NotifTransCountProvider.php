<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Kasir;
use App\Transaction;

class NotifTransCountProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('Template.Sidebar', function ($view) {
            $kasir = Kasir::where('user_id', Auth::user()->id)->first();
              if ($kasir) {
                $kios = $kasir->kios_id;
                $countTransStatus1 = Transaction::where('status_id', 1)->where('kios_id', $kios)->count();
                $countTransStatus2 = Transaction::where('status_id', 2)->where('kios_id', $kios)->count();
                $count = $countTransStatus1 + $countTransStatus2;
              } else {
                $count = 0;
              }

              $view->with('count', $count);
        });
    }
}
