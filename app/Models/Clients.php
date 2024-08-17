<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;
    protected $fillable = [
        'referred_by', 'name', 'phone', 'email', 'address', 'pin', 'city', 'state', 'country', 
        'image', 'password', 'assign', 'earnings', 'wallet_balance', 'role', 'is_Active'
    ];

    public function referrer()
    {
        return $this->belongsTo(Clients::class, 'referred_by');
    }
}
