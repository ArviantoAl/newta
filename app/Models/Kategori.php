<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'kategoris';
    protected $primaryKey = 'id_kategori';
    public $incrementing = true;
    protected $fillable = [
        'nama_kategori',
    ];

    public function layanan(){
        return $this->hasMany(Layanan::class);
    }
    public function langganan(){
        return $this->hasMany(Langganan::class);
    }
}
