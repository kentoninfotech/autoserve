<?php

namespace App\Models;

use App\Scopes\SettingScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jobs extends Model
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

    public function serviceorder()
    {
        return $this->hasMany(serviceorder::class, 'jobno', 'jobno');
    }

    public function sale()
    {
        return $this->hasMany(sale::class, 'jobid', 'jobno');
    }

    public function partsorder()
    {
        return $this->hasMany(partsorder::class, 'jobno', 'jobno');
    }

    public function diagnosis()
    {
        return $this->hasOne(diagnosis::class, 'jobno', 'jobno');
    }

    public function contact()
    {
        return $this->belongsTo(contacts::class, 'customerid', 'customerid');
    }

    public function payment()
    {
        return $this->hasMany(payments::class, 'jobno', 'jobno');
    }

    public function psfu()
    {
        return $this->hasMany(psfu::class, 'jobno', 'jobno');
    }

   }
