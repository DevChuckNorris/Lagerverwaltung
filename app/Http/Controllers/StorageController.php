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

    public function editPost(Request $request) {
        $this->validate($request, [
            'name' => 'required|max:255',
            'short' => 'required|max:255',
            'parent' => 'required',
            'id' => 'required|integer',
        ]);

        $storage = new Storage;
        if($request->get('id') != 0) {
            // old
            $storage = Storage::find($request->get('id'));
        }

        $storage->name = $request->get('name');
        $storage->short_code = $request->get('short');
        $storage->parent_storage = $request->get('parent') == 0 ? null : $request->get('parent');

        $storage->saveOrFail();

        return redirect()->action('StorageController@edit', ['id' => $storage->id]);
    }

    public function edit($id) {
        $storage = Storage::find($id);
        $all = $this->allStorage();

        return view('edit_storage', ['storage' => $storage, 'all' => $all]);
    }

    public function newStorage() {
        $storage = new Storage;
        $storage->id = 0;
        $all = $this->allStorage();

        return view('edit_storage', ['storage' => $storage, 'all' => $all]);
    }

    public function newStorageParent($parent) {
        $storage = new Storage;
        $storage->id = 0;
        $storage->parent_storage = $parent;
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
