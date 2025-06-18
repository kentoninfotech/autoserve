<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\SettingScope;

class CarOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_number',
        'status',
        'payment_status',
        // 'payment_method',
        'subtotal',
        'discount_percent',
        'discount_value',
        'vat_percent',
        'vat_value',
        'total',
        // 'order_date',
        // 'delivery_date',
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

    public function customer()
    {
        return $this->belongsTo(\App\Models\contacts::class, 'customer_id');
    }

    public function cars()
    {
        return $this->belongsToMany(CarInventory::class, 'car_order_items', 'order_id', 'car_id')
               ->withPivot('setting_id');
    }

    public function items()
    {
        return $this->hasMany(CarOrderItem::class, 'order_id');
    }
}
