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
        try {
            $superhero_temp = $request->all();
            
            //$superpowerList = (isset($superhero_temp['superpowerList']) ? $superhero_temp['superpowerList'] : null);

            $superhero = array_slice($superhero_temp, 0, 5);
            $this->storeSuperhero($superhero);

            $images = (isset($superhero_temp['images']) ? $superhero_temp['images'] : null);

            foreach($images as $image) {
                 
            }
            
            return redirect('superhero/')->with("successMessage", "Superhero Successfully Resgistered.");  
        } catch (Exception $e) {

        }
    }

    // Secundary Functions

    public function getAllSuperheroes() {
        return Superhero::all();
    }

    public function storeSuperhero($superhero) {
        return Superhero::create($superhero);
    }
}
