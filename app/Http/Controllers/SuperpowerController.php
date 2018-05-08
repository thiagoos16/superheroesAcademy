<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Superpower;

class SuperpowerController extends Controller
{
    public function index() {
        return view('superpower/index' ,[
            'superpower' => $this->getAllSuperpowers()
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
}
