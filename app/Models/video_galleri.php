<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class video_galleri extends Model
{
    protected $table = 'video_galleri';
	
	protected $fillable = [
        'id_users',
        'id_ukm',
        'nama',
        'description'
    ];

	protected $primaryKey = 'id';
	
	protected $guarded = [];
}
