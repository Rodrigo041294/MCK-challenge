<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class state extends Model
{
    use HasFactory;
    protected $fillable = [
        'cvegeo',
        'cve_agee',
        'nom_agee',
        'nom_abrev',
        'pob',
        'pob_fem',
        'pob_mas',
        'viv',
        'active'
    ];
}
