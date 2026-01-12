<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// app/Models/User.php
class User extends Authenticatable
{
    // ... postojeći kod ...

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // DODAJ OVO AKO VEĆ NIJE
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // app/Models/User.php - DODAJ OVE METODE NA KRAJ KLASE:
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isMenadzer()
    {
        return $this->role === 'menadzer';
    }

    public function isRadnik()
    {
        return $this->role === 'radnik';
    }

    public function isKlijent()
    {
        return $this->role === 'klijent';
    }

    public function canEdit()
    {
        // Admin i menadzer mogu da uređuju
        return $this->role === 'admin' || $this->role === 'menadzer';
    }
}
