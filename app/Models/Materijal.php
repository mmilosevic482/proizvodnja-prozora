<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materijal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'naziv',
        'tip',
        'jedinica_mere',
        'trenutna_kolicina',
        'minimalna_kolicina',
        'cena_po_jedinici',
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
            'trenutna_kolicina' => 'decimal:2',
            'minimalna_kolicina' => 'decimal:2',
            'cena_po_jedinici' => 'decimal:2',
        ];
    }
}
