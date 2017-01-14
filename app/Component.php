<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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

    public function storageStructure() {
        $ret = [];
        foreach ($this->storage as $cs) {
            $s = [];
            // Create tree structure (because we only have the last item in the tree
            // we need to create it with recursion)
            $storage = $cs->ref_storage;
            $this->addParent($storage, $s);

            $ret[] = $s;
        }

        return $ret;
    }

    private function addParent($storage, &$ret) {
        //Log::info('Type is ' . gettype($storage));
        if($storage == null) return;

        if($storage->parent != null) {
            $this->addParent($storage->parent, $ret);
        }

        $ret[] = $storage;
    }
}
