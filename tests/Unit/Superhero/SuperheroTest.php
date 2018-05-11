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
            'nickname' => 'Spawn',
            'real_name' => 'AL Simmons',
            'origin_description' => 'Albert Francis "Al" Simmons (Lt. Colonel, USMC-Ret.), born in Detroit Michigan, was a highly trained Force Recon Marine who was at his most successful point when he saved the President from an attempted assassination...',
            'catch_phrase' => 'Nothing to Say'
        ];

        $superhero = SuperheroController::storeSuperhero($data);

        $this->assertInstanceOf(Superhero::class, $superhero);
    }
}
