<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Superhero;
use App\Images;
use App\Http\Controllers\SuperpowerController;
use File;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use View;

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

        //Doing a Pagination
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $col = new Collection($superheroes);

        $perPage = 5;

        $currentPageSearchResults = $col->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $superheroes = new LengthAwarePaginator($currentPageSearchResults, count($col), $perPage);

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

                    foreach ($images as $image_temp) {
                        $this->attachImageToSuperhero($superhero->id, $image_temp);
                    }

                    foreach ($superpowerList as $superpower_id) {
                        $this->attachSuperpowerToSuperhero($superhero->id, $superpower_id);
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

    public function viewEdit($id) {
        $superhero = Superhero::find($id);
        $superpowers = $superhero->superpowers()->get();
        $images = $superhero->images()->get();
        $superpowersList = SuperpowerController::getAllSuperpowers();

        return view('superhero/edit', [
            'superhero' => $superhero,
            'superpowers' => $superpowers,
            'images' => $images,
            'superpowersList' => $superpowersList
        ]);
    }

    public function edit(Request $request) {
        try {
            $this->formValidation($request);

            Superhero::find($request->superhero_id)->update($request->all());
            
            return redirect('superhero/')->with("successMessage", "Superhero Successfully Edited.");
        } catch(Exception $e) {
            return redirect('superhero/viewEdit')->with("errorMessage", "Could Not Edit Superhero. Make sure the fields are filled in correctly."); 
        }
    }

    public function viewDelete($id) {
        $superhero = $this->findSuperheroById($id);

        return View::make('superhero.delete')->with('superhero', $superhero);
    }

    public function delete($id) {
        try {
            $superhero = $this->findSuperheroById($id);

            $this->detachSuperheroSuperpowers($superhero);

            $this->detachSuperheroImages($superhero);

            $superhero->delete();

            return redirect('superhero/')->with("successMessage", "Superhero Successfully Deleted.");
        } catch(Exception $e) {
            return redirect('superhero/')->with("errorMessage", "Could Not Delete Superhero."); 
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

    public static function findSuperheroById($id) {
        return Superhero::find($id);
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

    public function detachSuperheroImages($superhero) {
        return Images::where('superhero_id', $superhero->id)->delete();
    }

    public function attachSuperpowerToSuperhero($superhero_id, $superpower_id) {
        $superhero = $this->findSuperheroById($superhero_id);

        $superpower = SuperpowerController::findSuperpowerById($superpower_id);

        if (!$superhero->superpowers->contains($superpower)) {
            return $superhero->superpowers()->save($superpower);
        } else {
            false;
        }
    }

    public function detachSuperheroSuperpowers($superhero) {     
        $superpowers = $superhero->superpowers()->get();

        return $superhero->superpowers()->where('superhero_id', '==', $superhero->id)->detach();
    } 

    public function detachOneSuperpower($superhero_id, $superpower_id) {
        try {
            $superhhero = $this->findSuperheroById($superhero_id);

            return $superhhero->superpowers()->detach($superpower_id);
        } catch(Exception $e) {
            return false;
        }
    }

    public function addSupperpowers(Request $request) {
        try {
            $data = Input::all();

            $superhero_id = $data['superhero_id'];

            $superpowerList = (isset($data['superpowerList']) ? $data['superpowerList'] : null);

            foreach ($superpowerList as $superpower_id) {
                $this->attachSuperpowerToSuperhero($superhero_id, $superpower_id);
            }
            return redirect('superhero/viewEdit/'.$superhero_id)->with("successMessage", "Superpowers Successfully Added.");
        } catch (Exception $e) {
            return redirect('superhero/viewEdit/'.$superhero_id)->with("errorMessage", "Could not add Superpowers.");
        }  
    }

    public function detachOneImage($image_id) {
        try {
            Images::find($image_id)->delete();
            return redirect('superhero/')->with("successMessage", "Image Successfully Deleted.");
        } catch(Exception $e) {
            return false;
        }
    }
}
