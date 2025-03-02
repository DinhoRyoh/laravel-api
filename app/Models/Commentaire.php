<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
Use App\Models\Profil;

class Commentaire extends Model
{
    protected $guarded = [
        'id'
    ];

    public function profil()
    {
        return $this->belongsTo(Profil::class, 'profil_id');
    }
}
