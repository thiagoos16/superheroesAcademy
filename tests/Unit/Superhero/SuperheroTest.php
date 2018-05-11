<?php

namespace Tests\Unit\Superhero;

use Tests\TestCase;
use App\Http\Controllers\SuperheroController;
use App\Superhero;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SuperheroTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_create_superhero()
    {
        $data = [
            'nickname' => 'Superhero_Test_Case',
            'real_name' => 'AL Simmons',
            'origin_description' => 'Albert Francis "Al" Simmons (Lt. Colonel, USMC-Ret.), born in Detroit Michigan, was a highly trained Force Recon Marine who was at his most successful point when he saved the President from an attempted assassination...',
            'catch_phrase' => 'Nothing to Say'
        ];

        $superhero = SuperheroController::storeSuperhero($data);

        $this->assertInstanceOf(Superhero::class, $superhero);

        Superhero::find($superhero->id)->delete();
    }

    public function test_find_superhero_by_id()
    {
        $data = [
            'nickname' => 'Superhero_Test_Case',
            'real_name' => 'AL Simmons',
            'origin_description' => 'Albert Francis "Al" Simmons (Lt. Colonel, USMC-Ret.), born in Detroit Michigan, was a highly trained Force Recon Marine who was at his most successful point when he saved the President from an attempted assassination...',
            'catch_phrase' => 'Nothing to Say'
        ];

        $superhero = SuperheroController::storeSuperhero($data);

        $superhero_find = SuperheroController::findSuperheroById($superhero->id);

        $this->assertEquals($superhero->id, $superhero_find->id);

        Superhero::find($superhero->id)->delete();
    }

    public function test_not_find_superhero_by_id()
    {
        $id = 1; 

        $superhero_find = SuperheroController::findSuperheroById($id);

        $this->assertEquals($superhero_find, null);
    }
}
