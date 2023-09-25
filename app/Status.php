<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = "status";
    protected $primaryKey = "id";
    protected $fillable = [
        'id', 'status'
    ];

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
