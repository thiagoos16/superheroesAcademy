<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Superpower;
use View;

class SuperpowerController extends Controller
{
    public function index() {
        return view('superpower/index' ,[
            'superpowers' => $this->getAllSuperpowers(),
            'create' => 'Create'
        ]);
    }

    public function create(Request $request) {
        try {
            $this->formValidation($request);
            
            $this->storeSuperpower($request);
        
            return redirect('superpower/')->with("successMessage", "Superpower Successfully Resgistered.");    
        } catch(Exception $e) {
            return redirect('superpower/')->with("errorMessage", "Could Not Register Superpower."); 
        }
    }

    public function viewEdit($id) {
        $superpower = $this->findSuperpowerById($id);

        return View::make('superpower.index')->with([
            'superpower' => $superpower,
            'superpowers' => $this->getAllSuperpowers()
        ]);
    }

    public function edit(Request $request) {
        try {
            $this->formValidation($request);

            Superpower::find($request->id)->update($request->all());
            
            return redirect('superpower/')->with("successMessage", "Superpower Successfully Edited.");    
        } catch (Exception $e) {
            return redirect('superpower/')->with("errorMessage", "Could Not Edit Superpower."); 
        }
    }

    public function delete($id) {
        return Superpower::find($id)->delete();
    } 

    // Secundary Functions
    public static function getAllSuperpowers() {
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

    public function storeSuperpower($request) { 
        return Superpower::create($request->all());
    }

    public static function findSuperpowerById($id) {
        return Superpower::find($id);
    }
}
