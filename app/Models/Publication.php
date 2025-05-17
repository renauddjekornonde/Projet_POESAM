<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    protected $table = 'publications';
    
    protected $fillable = [
        'contenu',
        'media',
        'date_publication',
        'id_victime'
    ];

    public function victime()
    {
        return $this->belongsTo(Victime::class, 'id_victime');
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'id_publication');
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class, 'id_publication');
    }
}
