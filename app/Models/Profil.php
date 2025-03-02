<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
Use App\Models\Commentaire;

class Profil extends Model
{
    use HasFactory;
    
    protected $guarded = [
        'id'
    ];

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'profil_id');
    }
}
