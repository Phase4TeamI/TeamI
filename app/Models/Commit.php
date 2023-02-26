<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commit extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [
        'id',
    ];

    public function repository()
    {
        return $this->belongsTo(Repository::class);
    }
}
