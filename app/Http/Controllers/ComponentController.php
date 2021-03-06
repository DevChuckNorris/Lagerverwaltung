<?php

namespace App\Http\Controllers;

use App\Component;
use App\ComponentStorage;
use App\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ComponentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listComponents() {
        return view('components', [
            'components' => Component::all()
        ]);
    }

    public function view($id) {
        $component = Component::find($id);
        if($component == null) {
            $component = new Component;
            $component->id = 0;
        }

        $rootStorage = Storage::where('parent_storage', null)->get();

        return view('component', [
            'component' => $component,
            'rootStorage' => $rootStorage
        ]);
    }

    public function save(Request $request, $id) {
        $this->validate($request, [
            'item_number' => 'required|max:255',
            'description' => 'required',
            'id' => 'required|integer',
            'quantity' => 'required|integer|min:0',
            'min_quantity' => 'required|integer|min:0',
            'price' => 'required|numeric',
        ]);

        $component = new Component;
        if($id != 0) {
            $component = Component::find($id);
        }

        $component->item_number = $request->get('item_number');
        $component->description = $request->get('description');
        $component->quantity = $request->get('quantity');
        $component->min_quantity = $request->get('min_quantity');
        $component->price = $request->get('price');
        $component->runs_out = $request->has('out');
        if($component->runs_out) {
            $component->quantity = 0;
            $component->min_quantity = 0;
        }

        $component->saveOrFail();

        $storageIds = [];
        for($i = 0; $i < $request->get('storage'); $i++) {
            $last = $request->get('storage-' . $i) - 1;
            $storageIds[] = $request->get('storage-' . $i . '-' . $last);
        }

        if($component->runs_out) {
            $storageIds = []; // Force delete of all storage
        }

        $cStorage = $component->storage;
        // Store storage
        // Check unchecks
        foreach ($cStorage as $storage) {
            if(!in_array($storage->ref_storage->id, $storageIds)) {
                // delete
                $storage->delete();
            }
        }
        // Check new checks
        foreach($storageIds as $storage) {
            if($storage == 0) continue;

            $found = false;

            foreach ($cStorage as $cs) {
                if($cs->storage == $storage) {
                    $found = true;
                    break;
                }
            }

            if(!$found) {
                $new = new ComponentStorage;
                $new->component = $component->id;
                $new->storage = $storage;
                $new->saveOrFail();
            }
        }

        return redirect()->action('ComponentController@view', ['id' => $component->id]);
    }

    public function updateQuantity($id, $quantity) {
        $component = Component::find($id);
        if($component->runs_out) return $component->quantity;

        $component->quantity += $quantity;
        $component->saveOrFail();

        return $component->quantity;
    }

    public function storageChildren($id) {
        $return = [];

        $storage = Storage::where('parent_storage', $id == 0 ? null : $id)->orderBy('name', 'asc')->get();
        foreach ($storage as $s) {
            $return[] = [
                "id" => $s->id,
                "name" => $s->name,
                "short" => $s->short_code,
                "children" => sizeof($s->children)
            ];
        }

        return response()->json($return);
    }
}
