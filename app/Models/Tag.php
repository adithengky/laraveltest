<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    protected $primaryKey = 'id';
    protected $fillable = [
    	'tags_name' 
    ];

    public function itemTag() {
    	return $this->hasMany('App\Models\ItemTag');
    }
}
