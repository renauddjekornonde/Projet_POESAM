<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class reaction extends Model
{
    use hasFactory;
    protected $fillable = [
        'id_user',
        'id_publication',
        'type_reaction',
        'id_commentaire',

    ];
    public function publication()
    {
        return $this->belongsTo(publication::class, 'id_publication');
    }
    public function user()
    {
        return $this->belongsTo(user::class, 'id_user');
    }
    public function commentaire()
    {
        return $this->belongsTo(commentaire::class, 'id_commentaire');
    }
}
