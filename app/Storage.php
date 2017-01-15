<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $table = 'storage';

    public function path() {
        $parentPath = '';
        $parent = $this->parent;
        if($parent != null) {
            $parentPath = $parent->path();
        }

        if($parentPath == '') {
            return $this->short_code;
        }
        return $parentPath . ' > ' . $this->short_code;
    }

    public function children() {
        return $this->hasMany('App\Storage', 'parent_storage')->orderBy('name');
    }

    public function parent() {
        return $this->belongsTo('App\Storage', 'parent_storage');
    }

    public function components() {
        return $this->hasMany('App\ComponentStorage', 'storage');
    }

    public function sameLevelStorage() {
        return Storage::where('parent_storage', $this->parent_storage)->get();
    }
}
