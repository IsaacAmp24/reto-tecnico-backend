<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $table = 'divisions';
    protected $fillable = [
        'name',
        'parent_id',
        'level',
        'collaborators',
        'ambassadors',
    ];

    // Division superior
    public function parent(){
        return $this->belongsTo(Division::class, 'parent_id');
    }

    // Subdivisiones
    public function children(){
        return $this->hasMany(Division::class, 'parent_id');
    }

}
