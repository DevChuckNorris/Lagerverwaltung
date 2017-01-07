<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComponentStorage extends Model
{
    protected $table = 'component_storage';

    public function ref_component() {
        return $this->belongsTo('App\Component', 'component');
    }

    public function ref_storage() {
        return $this->belongsTo('App\Storage', 'storage');
    }
}
