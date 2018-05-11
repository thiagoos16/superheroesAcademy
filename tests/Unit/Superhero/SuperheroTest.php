<?php

namespace Tests\Unit\Superhero;

use Tests\TestCase;
use App\Http\Controllers\SuperheroController;
use App\Superhero;
use App\Images;
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

    public function test_edit_superhero() {
        $data = [
            'nickname' => 'Superhero_Test_Case',
            'real_name' => 'AL Simmons',
            'origin_description' => 'Albert Francis "Al" Simmons (Lt. Colonel, USMC-Ret.), born in Detroit Michigan, was a highly trained Force Recon Marine who was at his most successful point when he saved the President from an attempted assassination...',
            'catch_phrase' => 'Nothing to Say'
        ];

        $superhero = SuperheroController::storeSuperhero($data);

        $data_new = [
            'nickname' => 'Superhero_Edited',
            'real_name' => 'AL Simmons  Edited',
            'origin_description' => 'Albert Francis "Al" Simmons (Lt. Colonel, USMC-Ret.), born in Detroit Michigan, was a highly trained Force Recon Marine who was at his most successful point when he saved the President from an attempted assassination...',
            'catch_phrase' => 'Nothing to Say Edited'
        ];

        $superhero_edited = Superhero::find($superhero->id)->update($data_new);

        $this->assertTrue($superhero_edited);

        Superhero::find($superhero->id)->delete();
    }

    public function test_add_image_to_superhero() {
        $data = [
            'nickname' => 'Superhero_Test_Case',
            'real_name' => 'AL Simmons',
            'origin_description' => 'Albert Francis "Al" Simmons (Lt. Colonel, USMC-Ret.), born in Detroit Michigan, was a highly trained Force Recon Marine who was at his most successful point when he saved the President from an attempted assassination...',
            'catch_phrase' => 'Nothing to Say'
        ];

        $superhero = SuperheroController::storeSuperhero($data);

        $n_rand = rand(999999, 9999999);

        $data_image = [
            'path' => '../images/superhero-id_' . $superhero->id . '-test_image_' . $n_rand . '.jpg',
            'superhero_id' => $superhero->id
        ];

        $image = SuperheroController::storeImage($data_image);

        $this->assertInstanceOf(Images::class, $image);

        Superhero::find($superhero->id)->delete();

        Images::find($image->id)->delete();
    }
}
