<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;

    protected $table = 'commentaires';
    
    protected $fillable = [
        'contenu',
        'date_commentaire',
        'id_publication',
        'id_victime'
    ];

    public function publication()
    {
        return $this->belongsTo(Publication::class, 'id_publication');
    }

    public function victime()
    {
        return $this->belongsTo(Victime::class, 'id_victime');
    }
}
