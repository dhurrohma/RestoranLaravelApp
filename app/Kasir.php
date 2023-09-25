<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kasir extends Model
{
    protected $table = "kasir";
    protected $primaryKey = "id";
    protected $fillable = [
        'id', 'user_id', 'kios_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kios()
    {
        return $this->belongsTo(Kios::class, 'kios_id');
    }
}