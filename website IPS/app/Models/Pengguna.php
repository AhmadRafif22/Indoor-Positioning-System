<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;

    protected $table = 'pengguna';

    protected $fillable = [
        'user_id',
        'perangkat_id',
        'kode',
        'jabatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function perangkat()
    {
        return $this->belongsTo(Perangkat::class);
    }
}
