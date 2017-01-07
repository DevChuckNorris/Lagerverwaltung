<?php

namespace App\Http\Controllers;

use App\Component;
use App\ComponentStorage;
use Illuminate\Http\Request;

class ComponentController extends Controller
{
    public function listComponents() {
        return view('components', [
            'components' => Component::all()
        ]);
    }

    public function view($id) {
        $component = Component::find($id);
        $all = StorageController::allStorage();

        return view('component', [
            'component' => $component,
            'all' => $all
        ]);
    }

    public function save(Request $request, $id) {
        $this->validate($request, [
            'item_number' => 'required|max:255',
            'description' => 'required',
            'id' => 'required|integer',
            'quantity' => 'required|integer',
            'min_quantity' => 'required|integer',
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

        $component->saveOrFail();


        $cStorage = $component->storage;
        // Store storage
        // Check unchecks
        foreach ($cStorage as $storage) {
            if(!in_array($storage->id, $request->get('storage'))) {
                // delete
                $storage->delete();
            }
        }
        // Check new checks
        foreach($request->get('storage') as $storage) {
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
}
