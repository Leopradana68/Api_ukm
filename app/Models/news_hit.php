<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class news_hit extends Model
{
    protected $table = 'news_hit';
	
	protected $fillable = [
        'id_news',   
        'ip',
        'device'
    ];

	protected $primaryKey = 'id';
	
	protected $guarded = [];
}
