<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Superpower;

class SuperpowerController extends Controller
{
    public function index() {
        return view('superpower/index' ,[
            'superpower' => $this->getAllSuperpowers(),
            'action' => 'Create'
        ]);
    }

    public function create(Request $request) {
        return Superpower::create($request->all());
    }

    public function update(Request $request, $id) {
        return Superpower::find($id)->update($request->all());
    }

    public function delete($id) {
        return Superpower::find($id)->delete();
    } 

    // Secundary Functions
    public function getAllSuperpowers() {
        return $superpowers = Superpower::all();
    }

    public function formValidation(Request $request) {
        $this->validate($request, [
            'name' => 'required|min:3|max:190'
        ],[
            'name.required' => 'The Superpower Name is required.',
            'name.min' => 'The Superpower Name must be at least 3 characteres.',
            'name.max' => 'The Superpower Name may not be greater than 191 characteres.'
        ]);
    }
}
