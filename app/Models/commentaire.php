<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class commentaire extends Model
{
    use HasFactory;
    protected $fillable = [
        'contenu',
        'date_commentaire',
        'id_user',
        'id_publication',
    ];
    public function user()
    {
        return $this->belongsTo(user::class, 'id_user');
    }
    public function publication()
    {
        return $this->belongsTo(publication::class, 'id_publication');
    }
    public function reaction()
    {
        return $this->hasMany(reaction::class, 'id_commentaire');
    }
    public function signalement()
    {
        return $this->hasMany(signalement::class, 'id_commentaire');
    }
}
