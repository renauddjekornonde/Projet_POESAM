<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class organisation extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom_organisation',
        'description_organisation',
        'adresse_organisation',
        'telephone_organisation',
        'email_organisation',
        'site_web_organisation',
        'logo_organisation',
    ];
    public function annonces()
    {
        return $this->hasMany(annonce::class, 'id_organisation');
    }
    public function ressources()
    {
        return $this->hasMany(ressource::class, 'id_organisation');
    }
}
