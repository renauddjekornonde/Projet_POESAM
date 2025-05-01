<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class signalement extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_commentaire',
        'id_user',
        'id_publication',
        'date_signalement',
        'motif',
    ];
    public function commentaire()
    {
        return $this->belongsTo(commentaire::class, 'id_commentaire');
    }
    public function user()
    {
        return $this->belongsTo(user::class, 'id_user');
    }
    public function publication()
    {
        return $this->belongsTo(publication::class, 'id_publication');
    }
}
