<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disposer extends Model
{
    protected $table = 'disposer';
    protected $fillable = [
        'id_evenement',
        'id_evenement_categorie',
    ];

    public function evenement()
    {
        return $this->belongsTo(Evenement::class, 'id_evenement');
    }

    public function evenementCategorie()
    {
        return $this->belongsTo(EvenementCategorie::class, 'id_evenement_categorie');
    }
}
