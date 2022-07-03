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
        'layanan_kategori',
        'nama_layanan',
        'harga',
        'status',
        'bts_id',
    ];

    public function kategori(){
        return $this->belongsTo(Kategori::class, 'layanan_kategori');
    }
    public function bts(){
        return $this->belongsTo(Bts::class, 'bts_id');
    }
    public function langganan(){
        return $this->hasMany(Langganan::class);
    }
    public function langinv(){
        return $this->hasMany(Langinv::class);
    }
}
