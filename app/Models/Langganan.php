<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Langganan extends Model
{
    use HasFactory;
    protected $table = 'langganans';
    protected $primaryKey = 'id_langganan';
    public $incrementing = true;
    protected $fillable = [
        'layanan_id',
        'pelanggan_id',
        'alamat_pasang',
        'status',
    ];
    public function layanan(){
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }
    public function pelanggan(){
        return $this->belongsTo(User::class, 'pelanggan_id');
    }
    public function langinv(){
        return $this->hasMany(Langinv::class);
    }
}
