<?php

namespace App\Services;

use App\Models\Disposal;
use App\Models\AssetMovement;
use App\Models\LossWriteoff;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\GenericSystemNotification;

class NotificationService
{
    /**
     * Send notification for new disposal request.
     */
    public static function notifyNewDisposalRequest(Disposal $disposal): void
    {
        $admins = User::where('role', 'admin')->get();
        $assetName = $disposal->asset->nama_aset ?? 'Unknown';

        foreach ($admins as $admin) {
            Log::info('Notification: New disposal request', [
                'admin' => $admin->email,
                'disposal_id' => $disposal->id,
                'asset' => $assetName,
            ]);

            Mail::to($admin->email)->send(new GenericSystemNotification(
                'Permohonan Pelupusan Baru',
                [
                    'Permohonan pelupusan baru telah dihantar dan memerlukan tindakan anda.',
                    'Aset: ' . $assetName,
                    'Tujuan: ' . $disposal->justifikasi_pelupusan
                ],
                'Lihat Permohonan',
                route('admin.disposals.show', $disposal->id)
            ));
        }
    }

    /**
     * Send notification for disposal approval.
     */
    public static function notifyDisposalApproved(Disposal $disposal): void
    {
        $assetName = $disposal->asset->nama_aset ?? 'Unknown';

        Log::info('Notification: Disposal approved', [
            'disposal_id' => $disposal->id,
            'asset' => $assetName,
        ]);

        if ($disposal->user) {
            Mail::to($disposal->user->email)->send(new GenericSystemNotification(
                'Status Permohonan Pelupusan: Diluluskan',
                [
                    'Permohonan pelupusan aset anda telah diluluskan.',
                    'Aset: ' . $assetName,
                ]
            ));
        }
    }

    /**
     * Send notification for disposal rejection.
     */
    public static function notifyDisposalRejected(Disposal $disposal, string $reason): void
    {
        $assetName = $disposal->asset->nama_aset ?? 'Unknown';

        Log::info('Notification: Disposal rejected', [
            'disposal_id' => $disposal->id,
            'asset' => $assetName,
            'reason' => $reason,
        ]);

        if ($disposal->user) {
            Mail::to($disposal->user->email)->send(new GenericSystemNotification(
                'Status Permohonan Pelupusan: Ditolak',
                [
                    'Permohonan pelupusan aset anda telah ditolak.',
                    'Aset: ' . $assetName,
                    'Sebab: ' . $reason
                ]
            ));
        }
    }

    /**
     * Send notification for new asset movement request.
     */
    public static function notifyNewAssetMovementRequest(AssetMovement $movement): void
    {
        $admins = User::where('role', 'admin')->get();
        $assetName = $movement->asset->nama_aset ?? 'Unknown';

        foreach ($admins as $admin) {
            Log::info('Notification: New asset movement request', [
                'admin' => $admin->email,
                'movement_id' => $movement->id,
                'asset' => $assetName,
            ]);

            Mail::to($admin->email)->send(new GenericSystemNotification(
                'Permohonan Pergerakan Aset Baru',
                [
                    'Permohonan pergerakan aset baru telah dihantar dan memerlukan tindakan anda.',
                    'Aset: ' . $assetName,
                    'Destinasi: ' . ($movement->masjidSurauDestinasi->nama ?? $movement->lokasi_destinasi_spesifik)
                ],
                'Lihat Permohonan',
                route('admin.asset-movements.show', $movement->id)
            ));
        }
    }

    /**
     * Send notification for asset movement approval.
     */
    public static function notifyAssetMovementApproved(AssetMovement $movement): void
    {
        $assetName = $movement->asset->nama_aset ?? 'Unknown';

        Log::info('Notification: Asset movement approved', [
            'movement_id' => $movement->id,
            'asset' => $assetName,
        ]);

        if ($movement->user) {
            Mail::to($movement->user->email)->send(new GenericSystemNotification(
                'Status Pergerakan Aset: Diluluskan',
                [
                    'Permohonan pergerakan aset anda telah diluluskan.',
                    'Aset: ' . $assetName,
                ]
            ));
        }
    }

    /**
     * Send notification for asset movement rejection.
     */
    public static function notifyAssetMovementRejected(AssetMovement $movement, string $reason): void
    {
        $assetName = $movement->asset->nama_aset ?? 'Unknown';

        Log::info('Notification: Asset movement rejected', [
            'movement_id' => $movement->id,
            'asset' => $assetName,
            'reason' => $reason,
        ]);

        if ($movement->user) {
            Mail::to($movement->user->email)->send(new GenericSystemNotification(
                'Status Pergerakan Aset: Ditolak',
                [
                    'Permohonan pergerakan aset anda telah ditolak.',
                    'Aset: ' . $assetName,
                    'Sebab: ' . $reason
                ]
            ));
        }
    }

    /**
     * Send notification for new loss/writeoff report.
     */
    public static function notifyNewLossWriteoffRequest(LossWriteoff $lossWriteoff): void
    {
        $admins = User::where('role', 'admin')->get();
        $assetName = $lossWriteoff->asset->nama_aset ?? 'Unknown';

        foreach ($admins as $admin) {
            Log::info('Notification: New loss/writeoff report', [
                'admin' => $admin->email,
                'loss_writeoff_id' => $lossWriteoff->id,
                'asset' => $assetName,
            ]);

            Mail::to($admin->email)->send(new GenericSystemNotification(
                'Laporan Kehilangan / Hapus Kira Baru',
                [
                    'Laporan kehilangan atau hapus kira aset baru telah dihantar.',
                    'Aset: ' . $assetName,
                    'Keterangan: ' . $lossWriteoff->keterangan_kejadian
                ],
                'Lihat Laporan',
                route('admin.loss-writeoffs.show', $lossWriteoff->id)
            ));
        }
    }

    /**
     * Send notification for loss/writeoff approval.
     */
    public static function notifyLossWriteoffApproved(LossWriteoff $lossWriteoff): void
    {
        $assetName = $lossWriteoff->asset->nama_aset ?? 'Unknown';

        Log::info('Notification: Loss/writeoff approved', [
            'loss_writeoff_id' => $lossWriteoff->id,
            'asset' => $assetName,
        ]);

        if ($lossWriteoff->user) {
            Mail::to($lossWriteoff->user->email)->send(new GenericSystemNotification(
                'Status Laporan Kehilangan: Diluluskan',
                [
                    'Laporan kehilangan aset anda telah diluluskan untuk hapus kira.',
                    'Aset: ' . $assetName,
                ]
            ));
        }
    }

    /**
     * Send notification for upcoming inspection.
     */
    public static function notifyUpcomingInspection($asset, $daysUntilInspection): void
    {
        $assetName = $asset->nama_aset ?? 'Unknown';

        Log::info('Notification: Upcoming inspection', [
            'asset_id' => $asset->id,
            'asset_name' => $assetName,
            'days_until_inspection' => $daysUntilInspection,
        ]);

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new GenericSystemNotification(
                'Pemeriksaan Aset Hampir Tiba',
                [
                    'Pemeriksaan untuk aset berikut perlu dilakukan dalam masa ' . $daysUntilInspection . ' hari.',
                    'Aset: ' . $assetName,
                ],
                'Lihat Aset',
                route('admin.assets.show', $asset->id)
            ));
        }
    }

    /**
     * Send notification for overdue inspection.
     */
    public static function notifyOverdueInspection($asset): void
    {
        $assetName = $asset->nama_aset ?? 'Unknown';

        Log::info('Notification: Overdue inspection', [
            'asset_id' => $asset->id,
            'asset_name' => $assetName,
        ]);

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new GenericSystemNotification(
                'Pemeriksaan Aset Tertunggak',
                [
                    'Pemeriksaan untuk aset berikut telah melepasi tarikh yang sepatutnya.',
                    'Aset: ' . $assetName,
                ],
                'Sila Periksa Tindakan',
                route('admin.assets.show', $asset->id)
            ));
        }
    }

    /**
     * Send notification for warranty expiring soon.
     */
    public static function notifyWarrantyExpiring($asset, $daysUntilExpiry): void
    {
        $assetName = $asset->nama_aset ?? 'Unknown';

        Log::info('Notification: Warranty expiring soon', [
            'asset_id' => $asset->id,
            'asset_name' => $assetName,
            'days_until_expiry' => $daysUntilExpiry,
        ]);

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new GenericSystemNotification(
                'Jaminan Aset Tamat Tempoh Hampir',
                [
                    'Jaminan untuk aset berikut akan tamat tempoh dalam masa ' . $daysUntilExpiry . ' hari.',
                    'Aset: ' . $assetName,
                ],
                'Lihat Aset',
                route('admin.assets.show', $asset->id)
            ));
        }
    }

    /**
     * Send notification for upcoming maintenance.
     */
    public static function notifyUpcomingMaintenance($record, $daysUntilMaintenance): void
    {
        $assetName = $record->asset->nama_aset ?? 'Unknown';

        Log::info('Notification: Upcoming maintenance', [
            'record_id' => $record->id,
            'asset_name' => $assetName,
            'days_until_maintenance' => $daysUntilMaintenance,
        ]);

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new GenericSystemNotification(
                'Penyelenggaraan Aset Dikehendaki',
                [
                    'Penyelenggaraan untuk aset berikut dijadualkan dalam masa ' . $daysUntilMaintenance . ' hari.',
                    'Aset: ' . $assetName,
                ],
                'Lihat Rekod',
                route('admin.maintenance.show', $record->id)
            ));
        }
    }

    /**
     * Get pending notifications for a user.
     */
    public static function getPendingNotifications(User $user): array
    {
        $notifications = [];

        if ($user->role === 'admin') {
            // Pending disposal requests
            $pendingDisposals = Disposal::where('status_pelupusan', 'Dimohon')->count();
            if ($pendingDisposals > 0) {
                $notifications[] = [
                    'type' => 'disposal_pending',
                    'message' => "{$pendingDisposals} permohonan pelupusan menunggu kelulusan",
                    'count' => $pendingDisposals,
                    'url' => route('admin.disposals.index', ['status' => 'Dimohon']),
                ];
            }

            // Pending asset movements
            $pendingMovements = AssetMovement::where('status_pergerakan', 'menunggu_kelulusan')->count();
            if ($pendingMovements > 0) {
                $notifications[] = [
                    'type' => 'movement_pending',
                    'message' => "{$pendingMovements} permohonan pergerakan aset menunggu kelulusan",
                    'count' => $pendingMovements,
                    'url' => route('admin.asset-movements.index', ['status' => 'menunggu_kelulusan']),
                ];
            }

            // Pending loss/writeoffs
            $pendingLossWriteoffs = LossWriteoff::where('status_kejadian', 'Dilaporkan')->count();
            if ($pendingLossWriteoffs > 0) {
                $notifications[] = [
                    'type' => 'loss_writeoff_pending',
                    'message' => "{$pendingLossWriteoffs} laporan kehilangan menunggu kelulusan",
                    'count' => $pendingLossWriteoffs,
                    'url' => route('admin.loss-writeoffs.index', ['status' => 'Dilaporkan']),
                ];
            }

            // Overdue inspections
            $overdueInspections = \App\Models\Asset::where(function ($q) {
                $q->whereNull('tarikh_pemeriksaan_terakhir')
                    ->orWhere('tarikh_pemeriksaan_terakhir', '<', now()->subDays(90));
            })->count();

            if ($overdueInspections > 0) {
                $notifications[] = [
                    'type' => 'inspection_overdue',
                    'message' => "{$overdueInspections} aset perlu pemeriksaan",
                    'count' => $overdueInspections,
                    'url' => route('admin.inspections.index'),
                ];
            }
        }

        return $notifications;
    }
}
