<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class user extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'id_role',
        'telephone',
        'adresse',
        'date_naissance',
        'photo',
        'est_anonyme',
        'pseudonyme',

    ];
    public function role()
    {
        return $this->belongsTo(role::class, 'id_role');
    }
    public function annonces()
    {
        return $this->hasMany(annonce::class, 'id_user');
    }
    public function commentaires()
    {
        return $this->hasMany(commentaire::class, 'id_user');
    }
    public function signalement()
    {
        return $this->hasMany(signalement::class, 'id_signalement');
    }
    public function publications()
    {
        return $this->hasMany(publication::class, 'id_publication');
    }
    public function reaction()
    {
        return $this->hasMany(ressource::class, 'id_reaction');
    }
}
