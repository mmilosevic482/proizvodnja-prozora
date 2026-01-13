<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materijal extends Model
{
    use HasFactory;

    protected $table = 'materijals'; // mora da se poklapa sa tabelom u bazi

    protected $fillable = [
        'naziv',
        'tip',
        'jedinica_mere',
        'trenutna_kolicina',
        'minimalna_kolicina',
        'cena_po_jedinici',
        'opis',
        'slika',
    ];

    protected $casts = [
        'id' => 'integer',
        'trenutna_kolicina' => 'decimal:2',
        'minimalna_kolicina' => 'decimal:2',
        'cena_po_jedinici' => 'decimal:2',
    ];
}
