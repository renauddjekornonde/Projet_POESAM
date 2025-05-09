<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    use HasFactory;

    protected $table = 'annonce';
    
    protected $fillable = [
        'titre_annonce',
        'description_annonce',
        'date_publication',
        'id_organisation'
    ];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'id_organisation');
    }
}
