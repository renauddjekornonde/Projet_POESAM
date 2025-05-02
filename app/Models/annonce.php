<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class annonce extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'contenu',
        'date_annonce',
        'id_user',

    ];
    public function user()
    {
        return $this->belongsTo(user::class, 'id_user');
    }
    public function organisation()
    {
        return $this->belongsTo(organisation::class, 'id_organisation');
    }
}
