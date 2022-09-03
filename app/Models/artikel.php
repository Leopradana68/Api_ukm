<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class artikel extends Model
{
    protected $table = 'artikel';
	
	protected $fillable = [

        'id_ukm',
        'id_artikel_kategori',
        'title', 
        'intro', 
        'content',
        'foto_artikel',
        'total_hit'
    ];

	protected $primaryKey = 'id';
	
	protected $guarded = [];
}
