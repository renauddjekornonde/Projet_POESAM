<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class consulter_ressource extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_ressource',
        'id_user',
        'date_consultation',
    ];
    public function ressource()
    {
        return $this->belongsTo(ressource::class, 'id_ressource');
    }
    public function user()
    {
        return $this->belongsTo(user::class, 'id_user');
    }
}
