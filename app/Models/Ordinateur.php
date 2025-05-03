<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ordinateur extends Model
{
    protected $table = 'ordinateurs';
    protected $fillable = [
        'nom',
        'marque',
        'modele',
        'System_Exploitation',
        'version_System_Exploitation',
        'adresse_ip',
        'adresse_mac',
        'actif',
        'numero_serie',
    ];

    public function evenement()
    {
        return $this->hasMany(evenement::class);
    }
}
