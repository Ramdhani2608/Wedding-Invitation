<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guestbook extends Model
{
    protected $table = 'guests';

    protected $fillable = [
        'uuid',
        'nama_tamu',
        'no_hp',
        'alamat',
        'ucapan',
        'keterangan',
        'foto',
    ];
}
