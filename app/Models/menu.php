<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    protected $table = 'menu';
	
	protected $fillable = [
        'nama',
        'id_ukm',
       'id_news_kategori',
       'id_artikel_kategori',
       'id_image_galleri',
       'id_video_galleri',
       'id_static_page',
        'url', 
        'parent_id',
        'hint'
    ];

	protected $primaryKey = 'id';
	
	protected $guarded = [];
}
