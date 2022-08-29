<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ukm extends Model
{
    protected $table = 'ukm';
	
	protected $fillable = [
    'nama_ukm',
    'jenis', 
    'singkatan_ukm', 
    'nama_ketua', 
    'nama_wakil_ketua', 
    'nama_sekertaris',
    'keterangan'
    ];

	protected $primaryKey = 'id';
	
	protected $guarded = [];
}
