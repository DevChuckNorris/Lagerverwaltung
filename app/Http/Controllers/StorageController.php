<?php

namespace App\Http\Controllers;

use App\Storage;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $storage = Storage::where('parent_storage', null)->get();
        $all = [];
        $i = 0;
        foreach($storage as $s) {
            $i++;
            $s->tree_id = $i;
            $all[] = $s;
            $this->collectChildren($all, $s, $i);
        }

        return view('storage', ['storage' => $all]);
    }

    public function edit($id) {

    }

    private function collectChildren(&$storage, $s, &$i) {
        $parent = $i;

        $children = Storage::where('parent_storage', $s->id)->get();
        foreach ($children as $s) {
            $i++;
            $s->tree_id = $i;
            $s->tree_parent = $parent;

            $storage[] = $s;
            $this->collectChildren($storage, $s, $i);
        }
    }
}
