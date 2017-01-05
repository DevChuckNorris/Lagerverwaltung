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
        $all = $this->allStorage();

        return view('storage', ['storage' => $all]);
    }

    public function edit($id) {
        $storage = Storage::find($id);
        $all = $this->allStorage();

        return view('edit_storage', ['storage' => $storage, 'all' => $all]);
    }

    public function delete($id) {
        // Grab storage
        $storage = Storage::find($id);
        if($storage == null) {
            // Storage not found (invalid id)
            echo json_encode(['error' => true, 'message' => trans('app.remove_storage_failed_404')]);
            return;
        }

        // Delete storage with all children
        $this->deleteStorage($storage);

        echo json_encode(['error' => false]);
    }

    /**
     * Delete the storage with all the children
     * @param $storage \App\Storage
     */
    private function deleteStorage($storage) {
        foreach ($storage->children as $child) {
            $this->deleteStorage($child);
        }

        $storage->delete();
    }

    private function allStorage() {
        $storage = Storage::where('parent_storage', null)->get();
        $all = [];

        foreach($storage as $s) {
            $all[] = $s;
            $this->collectChildren($all, $s);
        }

        return $all;
    }

    private function collectChildren(&$storage, $s) {
        $children = $s->children;
        foreach ($children as $s) {
            $storage[] = $s;
            $this->collectChildren($storage, $s);
        }
    }
}
