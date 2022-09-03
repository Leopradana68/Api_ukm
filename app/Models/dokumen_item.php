<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dokumen_item extends Model
{
    protected $table = 'dokumen_item';
	
	protected $fillable = [
       'id_dokumen',
        'dokumen'
    ];

	protected $primaryKey = 'id';
	
	protected $guarded = [];
}
