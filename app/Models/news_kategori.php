<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class news_kategori extends Model
{
    protected $table = 'news_kategori';
	
	protected $fillable = [
        'id_ukm',
        'nama_kategori'
    ];

	protected $primaryKey = 'id';
	
	protected $guarded = [];
}
