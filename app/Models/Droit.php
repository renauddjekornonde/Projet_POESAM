<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Droit extends Model
{
    protected $table = 'droits';
    protected $fillable = [
        'id_role',
        'fonction',
        'description',
    ];
    public function role()
    {
        return $this->hasMany(Role::class);
    }
}
