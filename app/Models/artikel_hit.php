<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class artikel_hit extends Model
{
    protected $table = 'artikel_hit';
	
	protected $fillable = [
        'id_artikel',  
        'ip',
        'device'
    ];

	protected $primaryKey = 'id';
	
	protected $guarded = [];
}
