<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;

    protected $table = 'reactions';
    
    protected $fillable = [
        'type_reaction',
        'date_reaction',
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
