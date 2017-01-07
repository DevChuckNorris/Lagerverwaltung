<?php

namespace App\Http\Controllers;

use App\Component;
use Illuminate\Http\Request;

class ComponentController extends Controller
{
    public function listComponents() {
        return view('components', [
            'components' => Component::all()
        ]);
    }
}
