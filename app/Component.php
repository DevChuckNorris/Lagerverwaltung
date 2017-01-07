<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    public function storage() {
        return $this->hasMany('App\ComponentStorage', 'component');
    }

    public function isInStorage($storage) {
        foreach($this->storage as $s) {
            if($s->storage == $storage) return true;
        }
        return false;
    }
}
