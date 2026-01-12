<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StavkaNarudzbine extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'narudzbina_id',
        'proizvod_id',
        'sirina',
        'visina',
        'kolicina',
        'boja',
        'napomena',
        'cena',
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
            'narudzbina_id' => 'integer',
            'proizvod_id' => 'integer',
            'sirina' => 'decimal:2',
            'visina' => 'decimal:2',
            'cena' => 'decimal:2',
        ];
    }

    public function narudzbina(): BelongsTo
    {
        return $this->belongsTo(\App\Models\StavkaNarudzbine::class);
    }

    public function proizvod(): BelongsTo
    {
        return $this->belongsTo(Proizvod::class);
    }
}
