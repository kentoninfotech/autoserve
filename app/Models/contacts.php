<?php

namespace App\Models;
// use App\Models\vehicle;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\SettingScope;

class contacts extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new SettingScope);

        static::creating(function ($model) {
            if (auth()->check() && auth()->user()->setting_id && empty($model->setting_id)) {
                $model->setting_id = auth()->user()->setting_id;
            }
        });
        static::updating(function ($model) {
            if (auth()->check() && auth()->user()->setting_id && empty($model->setting_id)) {
                $model->setting_id = auth()->user()->setting_id;
            }
        });
    }

    public function vehicles()
    {
        return $this->hasMany(vehicle::class, 'customerid', 'customerid');
    }

    public function jobs()
    {
        return $this->hasMany(jobs::class, 'customerid', 'customerid');
    }

    public function payments()
    {
        return $this->hasMany(payments::class, 'customerid', 'customerid');
    }


}
