<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class image_galleri extends Model
{
    protected $table = 'image_galleri';
	
	protected $fillable = [
       'id_users',
       'id_ukm',
        'nama',
        'description'
    ];

	protected $primaryKey = 'id';
	
	protected $guarded = [];
}
