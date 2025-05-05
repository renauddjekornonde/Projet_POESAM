<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posseder extends Model
{
    protected $table = 'posseder';
    protected $fillable = [
        'id_droit',
        'id_role',
    ];
    public function droit()
    {
        return $this->belongsTo(Droit::class, 'id_droit');
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }
}
