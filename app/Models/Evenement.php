<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    protected $table = 'evenements';
    protected $fillable = [
        'nom',
        'adresse',
        'date_evenement',
        'id_ordinateur',

    ];

    public function evenementCategorie()
    {
        return $this->hasMany(EvenementCategorie::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function Disposer()
    {
        return $this->hasMany(Disposer::class);
    }
    public function ordinateur()
    {
        return $this->belongsTo(Ordinateur::class, 'id_ordinateur');
    }
}
