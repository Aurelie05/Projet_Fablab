<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renseignement extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenoms',
        'nb_enfants_5_10',
        'nb_enfants_11_17',
        'numero_whatsapp',
        'numero_enregistrement',
        'tarif',
    ];
    
}
