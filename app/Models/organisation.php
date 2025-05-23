<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organisation extends Model
{
    use HasFactory;
    protected $table = 'organisations';
    protected $fillable = [
        'id_user',
        'nom',
        'adresse',
        'telephone',
        'description',
        'logo',
        'status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
