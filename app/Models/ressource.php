<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ressource extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'contenu',
        'type_ressource',
        'date_ressource',
        'id_organisation',
    ];
    public function organisation()
    {
        return $this->belongsTo(organisation::class, 'id_organisation');
    }
    public function consulter_ressource()
    {
        return $this->hasMany(consulter_ressource::class, 'id_ressource');
    }
}
