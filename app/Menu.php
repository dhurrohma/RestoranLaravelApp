<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Menu extends Model
{
    protected $table = "menu";
    protected $primaryKey = "id";
    protected $fillable = [
        'id', 'kios_id', 'nama_menu', 'jenis', 'harga', 'deskripsi'
    ];

    public function kios()
    {
        return $this->belongsTo(Kios::class);
    }

    public function gambar(): hasOne
    {
        return $this->hasOne(Gambar::class, 'id_menu', 'id');
    }

    public function menu()
    {
        return $this->hasMany(Menu::class);
    }
}
