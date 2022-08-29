<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class artikel_kategori extends Model
{
    protected $table = 'artikel_kategori';
	
	protected $fillable = [
        'id_ukm',
        'nama_kategori'
    ];

	protected $primaryKey = 'id';
	
	protected $guarded = [];
}
