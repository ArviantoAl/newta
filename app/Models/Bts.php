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
        'detail_alamat',
        'alamat_pasang',
        'kategori_id',
        'status_id',
        'frekuensi',
        'ssid',
        'ip',
        'lokasi',
    ];

    public function jenis(){
        return $this->belongsTo(JenisBts::class, 'jenis_id');
    }
    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function kategori(){
        return $this->belongsTo(Kategori::class, 'kategori_id');
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
    public function langganan(){
        return $this->hasMany(Langganan::class);
    }
    public function turunan(){
        return $this->hasMany(TurunanBts::class);
    }
    public function perangkatbts(){
        return $this->hasMany(PerangkatBts::class);
    }
}
