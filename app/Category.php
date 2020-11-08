<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name', 'description', 'parent_id'];

    public function childs(){
        return $this->hasMany(Category::class,'parent_id','id');
    }
}
