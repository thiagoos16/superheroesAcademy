<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Superhero;
use App\Images;
use App\Http\Controllers\SuperpowerController;
use File;
use DB;
use Illuminate\Support\Facades\Input;

class SuperheroController extends Controller
{
    public function index() {
        return view('superhero/index', [
            'superheroes' => $this->getAllSuperheroes()
        ]);
    }

    public function viewCreate() {
        return view('superhero/create', [
            'superpowers' => SuperpowerController::getAllSuperpowers()
        ]);
    }

    public function create() {
        $superhero_temp = Input::all();
            
        $superhero = array_slice($superhero_temp, 0, 5);

        $images = (isset($superhero_temp['images']) ? $superhero_temp['images'] : null);
        $superpowerList = (isset($superhero_temp['superpowerList']) ? $superhero_temp['superpowerList'] : null);

        if (!is_null($images) && !is_null($superpowerList)) {
            if (!$this->existImagesWithError($images)) {
                DB::berginTransaction();
                try {
                    $this->formValidation($superhero); 
                    $superhero = $this->storeSuperhero($superhero);

                    // Creating Relationship Between Superhero and Images (Adding Images to Superhero) 
                    foreach ($images as $image_temp) {
                        $this->attachImageToSuperhero($superhero->id, $image_temp);
                    }

                    // Creating Relationship Between Superhero and Superpowers (Adding Superpowers to Superhero)
                    foreach ($superpowerList as $superpower_id) {
                        $superpower = SuperpowerController::findSuperpowerById($superpower_id);
                        $superhero->superpowers()->save($superpower);
                    } 

                    DB::commit();
                    return redirect('superhero/viewCreate')->with("successMessage", "Superhero Successfully Resgistered.");
                } catch (Exception $e) {
                    DB::rollback();
                    return redirect('superhero/viewCreate')->with("errorMessage", "Could Not Register Superhero. Exist any problem in Images or in Superpowers attributed to Superhero"); 
                }
            } else {
                return redirect('superhero/viewCreate')->with("errorMessage", "For one of the images are not supported. Insert images with extension in PNG or JPG.");
            }  
        } else {
            return redirect('superhero/viewCreate')->with("errorMessage", "To create Superhero you must enter at least an Image and an Superpower.");
        }
    }

    // Secundary Functions
    public function formValidation(Request $request) {
        
    } 

    public function getAllSuperheroes() {
        return Superhero::all();
    }

    public function storeSuperhero($superhero) {
        return Superhero::create($superhero);
    }

    public function storeImage($image) {
        return Images::create($image);
    }

    public function existImagesWithError($images) {
        foreach ($images as $image) {
            $extension = $image->getClientOriginalExtension();

            if (strtoupper($extension) != 'JPG' && strtoupper($extension) != 'PNG') {
                return true;
            }
        }

        return false;
    }

    public function attachImageToSuperhero($superhero_id, $images) {
        $extension = $image_temp->getClientOriginalExtension();

        $path = public_path().'/images/superhero-id_' . $superhero_id . '-image-' . rand(10, 999999) . '.' . $extension;
        File::move($image_temp, $path);
        
        $image = [];
        $image['superhero_id'] = $superhero->id;
        $image['path'] = $path;

        return $this->storeImage($image);
    }
}
