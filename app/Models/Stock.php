<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Databas\Seeders\UserSeeder;
use App\Models\User;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stocks';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'ticker_symbol',
        'transaction_price',
        'buy',
        'shares'
    ];

    public function user() {
        return $this->belongsTo(User::class);

    }
}
