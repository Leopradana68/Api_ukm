<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class video_galleri_item extends Model
{
    protected $table = 'video_galleri_item';
	
	protected $fillable = [
    'id_users',
    'id_galleri',
    'video_url',
    'tumbnail_url'
       
    ];

	protected $primaryKey = 'id';
	
	protected $guarded = [];
}
