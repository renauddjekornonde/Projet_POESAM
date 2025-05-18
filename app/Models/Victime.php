<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Victime extends Model
{
    protected $table = 'victimes';
    
    protected $fillable = [
        'nom',
        'prenom',
        'id_user'
    ];

    /**
     * Get the user that owns the victim.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
