<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProizvodniZadatak extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'stavka_narudzbine_id',
        'user_id',
        'operacija',
        'datum_pocetka',
        'datum_zavrsetka',
        'status',
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
            'stavka_narudzbine_id' => 'integer',
            'user_id' => 'integer',
            'datum_pocetka' => 'datetime',
            'datum_zavrsetka' => 'datetime',
        ];
    }

    public function stavkaNarudzbine(): BelongsTo
    {
        return $this->belongsTo(StavkaNarudzbine::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
