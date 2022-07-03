<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBts extends Model
{
    use HasFactory;
    protected $table = 'detail_bts';
    protected $primaryKey = 'id_detail_bts';
    public $incrementing = true;
    protected $fillable = [
        'bts_id',
        'nama_alat',
    ];

    public function bts(){
        return $this->belongsTo(Bts::class, 'bts_id');
    }
}
