<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Transaction;

class NotifOrderCountProvider extends ServiceProvider
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
            $orderStatus1 = Transaction::where('status_id', 1)->where('user_id', Auth::user()->id)->count();
            $orderStatus2 = Transaction::where('status_id', 2)->where('user_id', Auth::user()->id)->count();
            $countOrder = $orderStatus1 + $orderStatus2;
            
            $view->with('countOrder', $countOrder);
        });
    }
}
