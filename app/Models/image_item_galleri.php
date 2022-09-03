<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class image_item_galleri extends Model
{
    protected $table = 'image_item_galleri';
	
	protected $fillable = [
        'id_galleri',
        'description', 
        'foto',
    ];

	protected $primaryKey = 'id';
	
	protected $guarded = [];
}
