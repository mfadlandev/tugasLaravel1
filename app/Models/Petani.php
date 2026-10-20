<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petani extends Model
{
    use HasFactory;

    // $table diperlukan jika table tidak sesuai dengan format migration
    // protected $table = "petani";

    // $primaryKey diperlukan jika PK tidak sesuai dengan format
    public $primaryKey = 'id_penjual';

    // untuk mendeskripsikan field yang dapat dimanipulasi
    protected $fillable = [
        'nama', 
        'nik', 
        'alamat', 
        'telp', 
        'foto', 
        'id_kelompok_tani', 
        'status'
    ];

    public function kelompoktani()
    {
        // tabel petani mengambil referensi ke tabel kelompok tani
        // setiap petani adalah anggota dari kelompok tani
        // sehingga hubungan yang digunakan adalah belongsTo dari Petani ke KelompokTani
        // isikan foreign key id_kelompok_tani pada petanis dan owner key id_kelompok_tani pada kelompok_tanis
        // jika primary key tidak sesuai dengan standar laravel
        return $this->belongsTo(KelompokTani::class, 'id_kelompok_tani', 'id_kelompok_tani');
    }
}