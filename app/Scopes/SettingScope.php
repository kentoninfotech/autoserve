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
        if (Auth::check()) {
            // Check if the user has the "AutoServe" role
            if (!Auth::user()->hasRole('AutoServe')) {
                // Apply the scope only if the user does not have the "AutoServe" role
                if (Auth::user()->setting_id) {
                    $builder->where('setting_id', Auth::user()->setting_id);
                }
            }
        }
    }

}