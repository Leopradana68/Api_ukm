<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class artikel extends Model
{
    protected $table = 'artikel';
	
	protected $fillable = [
        'id_users',
        'id_ukm',
        'id_artikel_kategori',
        'title', 
        'intro', 
        'content',
        'image_file_data',
        'image_file_size',
        'image_file_name',
        'total_hit'
    ];

	protected $primaryKey = 'id';
	
	protected $guarded = [];
}
