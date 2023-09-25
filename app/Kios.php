<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kios extends Model
{
    protected $table = "kios";
    protected $primaryKey = "id";
    protected $fillable = [
        'id', 'kios', 'alamat', 'nama_pemilik', 'no_telp'
    ];

    public function menu()
    {
        return $this->hasMany(Menu::class);
    }

    public function kasir()
    {
        return $this->hasMany(Kasir::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

}
