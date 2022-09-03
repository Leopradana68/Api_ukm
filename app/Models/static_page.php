<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class static_page extends Model
{
    protected $table = 'static_page';
	
	protected $fillable = [
        'id_ukm',
        'title', 
        'intro', 
        'content'
    ];

	protected $primaryKey = 'id';
	
	protected $guarded = [];
}
