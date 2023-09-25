<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $table = "role";
    protected $primaryKey = "id";
    protected $fillable = [
        'id', 'role'
    ];

    public function user()
    {
        return $this->belongsToMany(User::class, 'user-role');
    }
}
