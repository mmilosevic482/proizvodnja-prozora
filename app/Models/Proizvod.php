<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proizvod extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'naziv',
        'opis',
        'tip',
        'standardna_sirina',
        'standardna_visina',
        'cena_po_m2',
        'aktivna',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'standardna_sirina' => 'decimal:2',
            'standardna_visina' => 'decimal:2',
            'cena_po_m2' => 'decimal:2',
            'aktivna' => 'boolean',
        ];
    }
}
