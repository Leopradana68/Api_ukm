<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dokumen extends Model
{
    protected $table = 'dokumen';
	
	protected $fillable = [
        'id_users',
        'id_ukm',
        'nama',
        'description'
    ];

	protected $primaryKey = 'id';
	
	protected $guarded = [];
}
