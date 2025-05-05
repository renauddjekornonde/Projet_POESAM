<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvenementCategorie extends Model
{
    protected $table = 'evenement_categories';
    protected $fillable = [
        'nom',
        'description',
    ];

    public function evenement()
    {
        return $this->hasMany(Evenement::class);
    }

    public function disposer()
    {
        return $this->hasMany(Disposer::class);
    }
}
