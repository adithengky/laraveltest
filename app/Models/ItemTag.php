<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemTag extends Model
{
    protected $table = 'item_tags';
    protected $primaryKey = 'id';
    protected $fillable = [
    	'blog_id', 'tag_id'
    ];

    public function blog() {
    	return $this->belongsTo('App\Models\Blog');
    }

    public function tag() {
    	return $this->belongsTo('App\Models\Tag');
    }
}
