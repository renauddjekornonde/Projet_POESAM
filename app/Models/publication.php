<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class publication extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'contenu',
        'date_publication',
        'id_user',
        'est_anonyme',
        'categorie',
    ];
    public function user()
    {
        return $this->belongsTo(user::class, 'id_user');
    }
    public function reaction()
    {
        return $this->hasMany(reaction::class, 'id_publication');
    }
    public function commentaire()
    {
        return $this->hasMany(commentaire::class, 'id_publication');
    }
}
