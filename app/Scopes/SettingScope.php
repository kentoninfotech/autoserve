<?php

namespace App\Scopes;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class SettingScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        if (Auth::check() && Auth::user()->setting_id) {
            $builder->where('setting_id', Auth::user()->setting_id);
        }
    }

}