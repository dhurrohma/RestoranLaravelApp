<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = "transaction";
    protected $primaryKey = "id";
    protected $fillable = [
        'id', 'trans_date', 'user_id', 'kios_id', 'total_price', 'status_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kios()
    {
        return $this->belongsTo(Kios::class);
    }

    public function transactionDetail()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
