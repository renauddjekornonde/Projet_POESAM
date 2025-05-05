<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrateur extends Model
{
    protected $table = 'administrateurs';
    protected $fillable = [
        'nom',
        'prenom',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
