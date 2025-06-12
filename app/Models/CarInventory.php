<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CarInventoryImage;
use App\Scopes\SettingScope;

class CarInventory extends Model
{
    use HasFactory;

    protected $table = 'car_inventories';

    protected $fillable = [
        'make',
        'model',
        'year',
        'vin',
        'mileage',
        'condition',
        'fuel_type',
        'transmission',
        'color',
        'price',
        'description',
        'status',
        'image',
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

    public function images()
    {
        return $this->hasMany(CarInventoryImage::class, 'car_inventory_id');
    }
}
