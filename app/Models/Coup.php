<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Coup extends Model
{
    protected $fillable = ['position', 'symbole'];

    public function partie(): BelongsTo
    {
        return $this->belongsTo(Partie::class);
    }
}