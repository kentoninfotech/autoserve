<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class settings extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Owner()
    {
        return $this->belongsTo(User::class);
    }
    
}
