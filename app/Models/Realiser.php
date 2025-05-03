<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Realiser extends Model
{
    protected $table = 'realiser';
    protected $fillable = [
        'id_evenement',
        'id_user',
    ];

    public function evenement()
    {
        return $this->belongsTo(Evenement::class, 'id_evenement');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
