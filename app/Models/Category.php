<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'id';
    protected $fillable = [
    	'category_name'
    ];

    public function blogs() {
    	return $this->hasMany('App\Models\Blog');
    }
}
