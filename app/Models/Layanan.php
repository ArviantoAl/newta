<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Layanan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'layanans';
    protected $primaryKey = 'id_layanan';
    public $incrementing = true;
    protected $fillable = [
        'nama_layanan',
        'harga',
        'layanan_kategori',
    ];

    public function kategori(){
        return $this->belongsTo(Kategori::class, 'layanan_kategori');
    }
    public function langganan(){
        return $this->hasMany(Langganan::class);
    }
    public function langinv(){
        return $this->hasMany(Langinv::class);
    }
}
