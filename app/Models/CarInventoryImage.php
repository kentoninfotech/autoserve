<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\SettingScope;

class CarInventoryImage extends Model
{
    protected $fillable = [
        'car_inventory_id',
        'image',
        'is_thumbnail',
    ];

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

    public function car()
    {
        return $this->belongsTo(CarInventory::class, 'car_inventory_id');
    }
    
}
