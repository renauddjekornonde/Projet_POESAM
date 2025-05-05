<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Victime extends Model
{
    protected $table = 'victimes';
    protected $fillable = [
        'nom',
        'prenom',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
