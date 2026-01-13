<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Narudzbina extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'klijent_id',
        'user_id',
        'broj_narudzbine',
        'datum_narudzbine',
        'rok_isporuke',
        'status',
        'ukupna_cena',
        'napomena',
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
            'klijent_id' => 'integer',
            'user_id' => 'integer',
            'datum_narudzbine' => 'date',
            'rok_isporuke' => 'date',
            'ukupna_cena' => 'decimal:2',
        ];
    }

    // app/Models/Narudzbina.php
    public function klijent()
    {
        return $this->belongsTo(Klijent::class, 'klijent_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
