<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bts extends Model
{
    use HasFactory;
    protected $table = 'bts';
    protected $primaryKey = 'id_bts';
    public $incrementing = true;
    protected $fillable = [
        'jenis_id',
        'nama_bts',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'desa_id',
        'status',
    ];

    public function layanan(){
        return $this->hasMany(Layanan::class);
    }
    public function jenis(){
        return $this->belongsTo(JenisBts::class, 'jenis_id');
    }
    public function provinsi(){
        return $this->belongsTo(Province::class, 'provinsi_id');
    }
    public function kabupaten(){
        return $this->belongsTo(Regency::class, 'kabupaten_id');
    }
    public function kecamatan(){
        return $this->belongsTo(District::class, 'kecamatan_id');
    }
    public function desa(){
        return $this->belongsTo(Village::class, 'desa_id');
    }
}
