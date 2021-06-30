<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    // public $guarded = [];
    protected $table = "bukus";
    protected $primaryKet = "id";
    protected $fillable = [
        'id', 'judulBuku', 'penulis', 'penerbit', 'gambar','public_id'
    ];

}
