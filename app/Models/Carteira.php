<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carteira extends Model
{
    use HasFactory;

    protected $table = 'carteira';

    protected $fillable = [
        'user_id',
        'acao',
        'quantidade',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
