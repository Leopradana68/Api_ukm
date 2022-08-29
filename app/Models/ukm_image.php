<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ukm_image extends Model
{
    protected $table = 'ukm_image';
	
	protected $fillable = [
        'foto_ukm_mime_type', 
        'foto_ukm_file_data',
        'foto_ukm_file_size',
        'foto_ukm_file_name', 
        'foto_ketua_mime_type',
        'foto_ketua_file_data',
        'foto_ketua_file_size',
        'foto_ketua_file_name', 
        'foto_wakil_ketua_mime_type', 
        'foto_wakil_ketua_file_data',
        'foto_wakil_ketua_file_size',
        'foto_wakil_ketua_file_name',
        'foto_sekertaris_mime_type',
        'foto_sekertaris_file_data',
        'foto_sekertaris_file_size',
        'foto_sekertaris_file_name'
    ];

	protected $primaryKey = 'id';
	
	protected $guarded = [];
}
