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
        $superheroes_aux = $this->getAllSuperheroes();
        $superheroes = [];

        foreach ($superheroes_aux as $superhero) {
            $temp_superhero = $superhero;

            $temp_superhero['image'] = $superhero->images()->first();

            $superheroes[] = $temp_superhero;
        }

        return view('superhero/index', [
            'superheroes' => $superheroes 
        ]);
    }

    public function viewCreate() {
        return view('superhero/create', [
            'superpowers' => SuperpowerController::getAllSuperpowers()
        ]);
    }

    public function create(Request $request) {
        $this->formValidation($request);

        $superhero_temp = Input::all();
            
        $superhero = array_slice($superhero_temp, 0, 5);

        $images = (isset($superhero_temp['images']) ? $superhero_temp['images'] : null);
        $superpowerList = (isset($superhero_temp['superpowerList']) ? $superhero_temp['superpowerList'] : null);

        if (!is_null($images) && !is_null($superpowerList)) {
            if (!$this->existImagesWithError($images)) {
                DB::beginTransaction();
                try { 
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
                    return redirect('superhero/')->with("successMessage", "Superhero Successfully Resgistered.");
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
        $this->validate($request, [
            'nickname' => 'required|min:3|max:190|unique:superhero',
            'real_name' => 'required|min:3|max:190|',
            'origin_description' => 'required',
            'catch_phrase' => 'required'
        ],[
            'nickname.required' => 'The Superhero Nickname is required.',
            'nickname.min' => 'The Superhero Nickname must be at least 3 characteres.',
            'nickname.max' => 'The Superhero Nickname may not be greater than 191 characteres.',
            'nickname.unique' => 'The Superhero Nickname already been registered.',
            'real_name.required' => 'The Superhero Real Name is required.',
            'real_name.min' => 'The Superhero Real Name must be at least 3 characteres.',
            'real_name.max' => 'The Superhero Real Name may not be greater than 191 characteres.',
            'origin_description.required' => 'The Superhero Origin Description is required.',
            'catch_phrase.required' => 'The Superhero Catch Phrase is required.'
        ]);
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

    public function attachImageToSuperhero($superhero_id, $image_temp) {
        $extension = $image_temp->getClientOriginalExtension();

        $n_rand = rand(10, 999999);

        $pathToMove = public_path().'/images/superhero-id_' . $superhero_id . '-image_' . $n_rand . '.' . $extension;
        File::move($image_temp, $pathToMove);
        
        $pathToStore = '../images/superhero-id_' . $superhero_id . '-image_' . $n_rand . '.' . $extension;

        $image = [];
        $image['superhero_id'] = $superhero_id;
        $image['path'] = $pathToStore;

        return $this->storeImage($image);
    }
}
