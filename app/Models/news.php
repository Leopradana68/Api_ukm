<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class news extends Model
{
    protected $table = 'news';
	
	protected $fillable = [
        'id_ukm',
        'id_news_kategori',
        'title', 
        'intro', 
        'content',
        'foto_news',
        'total_hit'
    ];

	protected $primaryKey = 'id';
	
	protected $guarded = [];
}
