<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function repository()
    {
        return $this->belongsTo(Repository::class);
    }
}
