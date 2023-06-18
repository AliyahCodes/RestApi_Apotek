<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Apotek extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'rujukan',
        'rumah_sakit',
        'obat',
        'harga_satuan',
        'total_harga',
        'apoteker',
    ];

     /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'obat' => 'array',
        'harga_satuan' => 'array',
    ];
    
    public function getObatAttribute($array) {
        return array_map(fn ($item) => trim($item, '"'), explode(',', $array));
    }

    public function getHargaSatuanAttribute($array) {
        return array_map(fn ($item) => trim($item, '"'), explode(',', $array));
    }
}
