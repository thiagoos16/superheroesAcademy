<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Superhero;
use App\Http\Controllers\SuperpowerController;

class SuperheroController extends Controller
{
    public function index() {
        return view('superhero/index', [
            'superheroes' => $this->getAllSuperheroes()
        ]);
    }

    public function viewCreate() {
        $superpowers = SuperpowerController::getAllSuperpowers();

        return view('superhero/create', [
            'superpowers' => $superpowers
        ]);
    }

    public function create(Request $request) {

    }

    // Secundary Functions

    public function getAllSuperheroes() {
        return Superhero::all();
    }
}
