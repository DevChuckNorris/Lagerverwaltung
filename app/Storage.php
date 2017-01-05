<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $table = 'storage';

    public function children() {
        return $this->hasMany('App\Storage', 'parent_storage');
    }

    public function parent() {
        return $this->belongsTo('App\Storage', 'parent_storage');
    }
}
