<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\SettingScope;

class CarOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'car_id',
        'price',
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

    public function order()
    {
        return $this->belongsTo(CarOrder::class, 'order_id');
    }

    public function car()
    {
        return $this->belongsTo(CarInventory::class, 'car_id');
    }
}
