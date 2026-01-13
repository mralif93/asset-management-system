<?php

namespace App\Helpers;

use App\Models\Asset;
use App\Models\AssetMovement;

class BatchHelper
{
    /**
     * Get the effective available quantity for a batch of assets at a specific location.
     * 
     * @param string $batchId
     * @param int $locationId (MasjidSurau ID)
     * @return int
     */
    public static function getAvailableQuantity(string $batchId, int $locationId): int
    {
        // 1. Count total assets in this batch at this location
        $totalAssets = Asset::where('batch_id', $batchId)
            ->where('masjid_surau_id', $locationId)
            ->where('status_aset', '!=', Asset::STATUS_DISPOSED) // Assuming 'Dilupuskan' means gone
            ->count();

        // 2. Count assets from this batch at this location that have ACTIVE pending movements
        // (i.e., they are technically still "here" but are "reserved" for a move)
        $pendingMovementsCount = AssetMovement::whereIn('asset_id', function ($query) use ($batchId, $locationId) {
            $query->select('id')
                ->from('assets')
                ->where('batch_id', $batchId)
                ->where('masjid_surau_id', $locationId);
        })
            ->where('status_pergerakan', 'menunggu_kelulusan') // Pending approval
            ->count();

        // 3. Subtract pending from total
        return max(0, $totalAssets - $pendingMovementsCount);
    }
}
