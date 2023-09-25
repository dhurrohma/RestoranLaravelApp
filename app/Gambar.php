<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gambar extends Model
{
    protected $table = "gambar";
    protected $primaryKey = "id";
    protected $fillable = [
        'id', 'id_menu', 'gambar'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
