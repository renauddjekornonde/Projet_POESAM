<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ressource extends Model
{
    use HasFactory;

    protected $table = 'ressource';
    
    protected $fillable = [
        'titre_ressource',
        'description_ressource',
        'lien_ressource',
        'type_ressource',
        'id_organisation'
    ];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'id_organisation');
    }
}
