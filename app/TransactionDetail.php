<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $table = "transaction_detail";
    protected $primaryKey = "id";
    protected $fillable = [
        'id', 'transaction_id', 'menu_id', 'quantity', 'total_price_item'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
