<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /** @test */
    public function user_model_se_moze_instancirati()
    {
        $user = new User();

        $this->assertInstanceOf(User::class, $user);
        $this->assertIsObject($user);
    }

    /** @test */
    public function user_ima_ime_i_email_atribute()
    {
        $user = new User();

        // Proveri da li su ova polja u fillable
        $fillable = $user->getFillable();

        // Samo proveri da li postoje, ne tačan redosled
        $this->assertContains('name', $fillable, 'User model treba da ima name polje');
        $this->assertContains('email', $fillable, 'User model treba da ima email polje');
    }

    /** @test */
    public function user_se_moze_kreirati_sa_podacima()
    {
        $user = new User([
            'name' => 'Test Korisnik',
            'email' => 'test@test.com',
        ]);

        $this->assertEquals('Test Korisnik', $user->name);
        $this->assertEquals('test@test.com', $user->email);
    }
}
