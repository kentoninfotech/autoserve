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
    
    public function accounts()
    {
        return $this->hasMany(BankAccount::class, 'setting_id');
    }
}
