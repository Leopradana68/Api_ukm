<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class image_item_galleri extends Model
{
    protected $table = 'image_item_galleri';
	
	protected $fillable = [
        'id_users',
        'id_galleri',
        'description', 
        'image_mime_type',
        'foto_ketua_file_size',
        'foto_ketua_file_name',
      'foto_ketua_file_data'
    ];

	protected $primaryKey = 'id';
	
	protected $guarded = [];
}
