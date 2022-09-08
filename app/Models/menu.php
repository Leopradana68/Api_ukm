<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    use HasFactory;

    public function parent() 
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children() 
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    
  
    protected $table = 'menu';
	

	protected $fillable = [
        'nama',
        'url', 
        'parent_id',
        'hint'
    ];

	protected $primaryKey = 'id';
	
	protected $guarded = [];
}
