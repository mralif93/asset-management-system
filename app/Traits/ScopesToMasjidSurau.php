<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait ScopesToMasjidSurau
{
    protected static function bootScopesToMasjidSurau()
    {
        static::addGlobalScope('masjid_surau', function (Builder $builder) {
            // Only apply scope if user is logged in, has a masjid_surau_id, and is NOT a superadmin
            if (Auth::check() && Auth::user()->role !== 'administrator' && Auth::user()->masjid_surau_id) {
                $masjidSurauId = Auth::user()->masjid_surau_id;
                $model = $builder->getModel();

                if (method_exists($model, 'asset')) {
                    // For models like Disposal, Inspection, Movement that relate to an Asset
                    $builder->whereHas('asset', function ($query) use ($masjidSurauId) {
                        // Avoid applying the scope recursively to the Asset model temporarily, 
                        // though whereHas normally handles this cleanly.
                        $query->withoutGlobalScope('masjid_surau')
                            ->where('masjid_surau_id', $masjidSurauId);
                    });
                } else {
                    // For models like Asset or ImmovableAsset that directly have masjid_surau_id
                    $builder->where($model->getTable() . '.masjid_surau_id', $masjidSurauId);
                }
            }
        });
    }
}
