<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', function () {
    return view('Pengguna.login');
})->name('login');

Route::post('/postlogin', 'LoginController@postlogin')->name('postlogin');

Route::get('/logout', 'LoginController@logout')->name('logout');

Route::get('/register', 'LoginController@register')->name('register');

Route::post('/register-user', 'LoginController@registerUser')->name('register-user');

Route::get('activate/{token}', 'LoginController@activateAccount')->name('activate-account');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('Beranda');

    // Hanya bisa diakses ADMIN
    Route::middleware(['checkRole:1'])->group(function () {
        //User
        Route::get('/user', 'UserController@index')->name('data-user');
        Route::get('/edit-user/{id}', 'UserController@edit')->name('edit-user');
        Route::post('/update-user/{id}', 'UserController@update')->name('update-user');
        Route::get('/delete-user/{id}', 'UserController@destroy')->name('delete-user');

        //Role
        Route::get('/role', 'RoleController@index')->name('data-role');
        Route::get('/create-role', 'RoleController@create')->name('create-role');
        Route::post('/save-role', 'RoleController@store')->name('save-role');
        Route::get('/edit-role/{id}', 'RoleController@edit')->name('edit-role');
        Route::post('/update-role/{id}', 'RoleController@update')->name('update-role');
        Route::get('/delete-role/{id}', 'RoleController@destroy')->name('delete-role');

        //Kios
        Route::get('/create-kios', 'KiosController@create')->name('create-kios');
        Route::post('/save-kios', 'KiosController@store')->name('save-kios');
        Route::get('/delete-kios/{id}', 'KiosController@destroy')->name('delete-kios');
        Route::get('/edit-kios/{id}', 'KiosController@edit')->name('edit-kios');
        Route::post('/update-kios/{id}', 'KiosController@update')->name('update-kios');
    });

    // Hanya bisa diakses ADMIN dan KASIR
    Route::middleware(['checkRole:1,2'])->group(function () {
        //Kios
        Route::get('/kios', 'KiosController@index')->name('kios');

        //Menu
        Route::get('/create-menu', 'MenuController@create')->name('create-menu');
        Route::post('/save-menu', 'MenuController@store')->name('save-menu');
        Route::get('/edit-menu/{id}', 'MenuController@edit')->name('edit-menu');
        Route::post('/update-menu/{id}', 'MenuController@update')->name('update-menu');
        Route::get('/delete-menu/{id}', 'MenuController@destroy')->name('delete-menu');

        //Gambar
        Route::get('/create-gambar', 'UploadgambarController@create')->name('create-gambar');
        Route::post('/simpan-gambar', 'UploadgambarController@store')->name('simpan-gambar');
        Route::get('/edit-gambar/{id}', 'UploadgambarController@edit')->name('edit-gambar');
        Route::post('/update-gambar/{id}', 'UploadgambarController@update')->name('update-gambar');
        Route::get('/delete-gambar/{id}', 'UploadgambarController@destroy')->name('delete-gambar');

        //Transaction
        Route::get('/trans-report', 'TransactionController@index')->name('trans-report');
    });

    // Dapat diakses semua user

    // Menu
    Route::get('/menu', 'MenuController@index')->name('data-menu');
    Route::get('/print-menu', 'MenuController@print')->name('print-menu');

    // Gambar
    Route::get('/gambar', 'UploadgambarController@index')->name('gambar');

    // Transaction
    Route::get('/order-history', 'TransactionController@orderHistory')->name('order-history');
    Route::get('/buat-pesanan', 'TransactionController@createPesanan')->name('buat-pesanan');
    Route::post('/submit-pesanan', 'TransactionController@storePesanan')->name('submit-pesanan');

    Route::get('/select-kios', 'TransactionController@showKios')->name('select-kios');
    Route::get('/select-menu/{kiosId}', 'TransactionController@showMenus')->name('select-menu');
    Route::post('/simpan-pesanan', 'TransactionController@storePesanan')->name('simpan-pesanan');
    Route::post('/update-status', 'TransactionController@updateStatus');
    Route::get('/print-report', 'TransactionController@printReport')->name('print-report');
    Route::get('/invoice/{transactionId}', 'TransactionController@generateInvoice')->name('invoice');

});

