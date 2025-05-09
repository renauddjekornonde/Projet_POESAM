<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signalement extends Model
{
    use HasFactory;

    protected $table = 'signalement';
    
    protected $fillable = [
        'description_signalement',
        'date_signalement',
        'statut_signalement',
        'id_victime',
        'id_publication'
    ];

    public function victime()
    {
        return $this->belongsTo(Victime::class, 'id_victime');
    }

    public function publication()
    {
        return $this->belongsTo(Publication::class, 'id_publication');
    }
}
