<?php

namespace App\Helpers;

use Carbon\Carbon;

class BatchIdGenerator
{
    /**
     * Generate a unique batch ID
     * Format: BATCH-YYYYMMDD-XXXXX
     * Example: BATCH-20241218-00001
     */
    public static function generate(): string
    {
        $date = Carbon::now()->format('Ymd');
        $prefix = "BATCH-{$date}-";

        // Get the last batch ID for today
        $lastBatchId = \DB::table('assets')
            ->where('batch_id', 'LIKE', $prefix . '%')
            ->orderBy('batch_id', 'desc')
            ->value('batch_id');

        if (!$lastBatchId) {
            // First batch of the day
            $sequence = 1;
        } else {
            // Extract sequence number and increment
            $lastSequence = (int) substr($lastBatchId, -5);
            $sequence = $lastSequence + 1;
        }

        return $prefix . str_pad($sequence, 5, '0', STR_PAD_LEFT);
    }
}
