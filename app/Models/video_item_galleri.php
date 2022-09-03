<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class video_item_galleri extends Model
{
    protected $table = 'video_item_galleri';
	
	protected $fillable = [
    'id_galleri',
    'video_url',
    'tumbnail_url'
       
    ];

	protected $primaryKey = 'id';
	
	protected $guarded = [];
}
