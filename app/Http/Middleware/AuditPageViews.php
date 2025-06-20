<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\AuditTrailService;
use Illuminate\Support\Facades\Auth;

class AuditPageViews
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only log for authenticated users and successful GET requests
        if (Auth::check() && 
            $request->isMethod('GET') && 
            $response->getStatusCode() === 200 &&
            $this->shouldLogPageView($request)) {
            
            try {
                $routeName = $request->route()?->getName();
                $description = $this->getPageDescription($routeName, $request);
                
                AuditTrailService::logCustom(
                    'PAGE_VIEW',
                    $description,
                    null,
                    [
                        'route_name' => $routeName,
                        'full_url' => $request->fullUrl(),
                        'referrer' => $request->header('referer'),
                        'user_agent' => $request->header('user-agent'),
                    ]
                );
            } catch (\Exception $e) {
                // Don't break the application if audit logging fails
                logger()->error('Failed to log page view: ' . $e->getMessage());
            }
        }

        return $response;
    }

    /**
     * Determine if we should log this page view
     */
    private function shouldLogPageView(Request $request): bool
    {
        $routeName = $request->route()?->getName();
        
        // Don't log these types of requests
        $excludePatterns = [
            '/api/',
            '/assets/',
            '/css/',
            '/js/',
            '/images/',
            '/fonts/',
            '.css',
            '.js',
            '.png',
            '.jpg',
            '.jpeg',
            '.gif',
            '.svg',
            '.ico',
            '.woff',
            '.woff2',
            '.ttf',
        ];

        $url = $request->getRequestUri();
        foreach ($excludePatterns as $pattern) {
            if (str_contains($url, $pattern)) {
                return false;
            }
        }

        // Don't log certain routes
        $excludeRoutes = [
            'audit-trails.user-activity', // API endpoints
            'logout', // Already logged in auth controller
        ];

        if (in_array($routeName, $excludeRoutes)) {
            return false;
        }

        // Only log admin routes and main dashboard routes
        $includeRoutePatterns = [
            'admin.',
            'user.dashboard',
            'profile.',
        ];

        if (!$routeName) {
            return false;
        }

        foreach ($includeRoutePatterns as $pattern) {
            if (str_starts_with($routeName, $pattern)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get a human-readable description for the page view
     */
    private function getPageDescription(string $routeName = null, Request $request): string
    {
        if (!$routeName) {
            return 'Melawat halaman: ' . $request->getRequestUri();
        }

        $descriptions = [
            // Dashboard
            'admin.dashboard' => 'Melawat papan pemuka admin',
            'admin.system-overview' => 'Melawat gambaran keseluruhan sistem',
            'user.dashboard' => 'Melawat papan pemuka pengguna',
            
            // Users
            'admin.users.index' => 'Melawat senarai pengguna',
            'admin.users.show' => 'Melihat detail pengguna',
            'admin.users.create' => 'Melawat borang tambah pengguna',
            'admin.users.edit' => 'Melawat borang edit pengguna',
            
            // Assets
            'admin.assets.index' => 'Melawat senarai aset',
            'admin.assets.show' => 'Melihat detail aset',
            'admin.assets.create' => 'Melawat borang tambah aset',
            'admin.assets.edit' => 'Melawat borang edit aset',
            
            // Asset Movements
            'admin.asset-movements.index' => 'Melawat senarai pergerakan aset',
            'admin.asset-movements.show' => 'Melihat detail pergerakan aset',
            'admin.asset-movements.create' => 'Melawat borang tambah pergerakan aset',
            'admin.asset-movements.edit' => 'Melawat borang edit pergerakan aset',
            
            // Inspections
            'admin.inspections.index' => 'Melawat senarai pemeriksaan',
            'admin.inspections.show' => 'Melihat detail pemeriksaan',
            'admin.inspections.create' => 'Melawat borang tambah pemeriksaan',
            'admin.inspections.edit' => 'Melawat borang edit pemeriksaan',
            
            // Maintenance Records
            'admin.maintenance-records.index' => 'Melawat senarai rekod penyelenggaraan',
            'admin.maintenance-records.show' => 'Melihat detail rekod penyelenggaraan',
            'admin.maintenance-records.create' => 'Melawat borang tambah rekod penyelenggaraan',
            'admin.maintenance-records.edit' => 'Melawat borang edit rekod penyelenggaraan',
            
            // Disposals
            'admin.disposals.index' => 'Melawat senarai pelupusan',
            'admin.disposals.show' => 'Melihat detail pelupusan',
            'admin.disposals.create' => 'Melawat borang tambah pelupusan',
            'admin.disposals.edit' => 'Melawat borang edit pelupusan',
            
            // Loss Write-offs
            'admin.loss-writeoffs.index' => 'Melawat senarai kehilangan',
            'admin.loss-writeoffs.show' => 'Melihat detail kehilangan',
            'admin.loss-writeoffs.create' => 'Melawat borang tambah kehilangan',
            'admin.loss-writeoffs.edit' => 'Melawat borang edit kehilangan',
            
            // Immovable Assets
            'admin.immovable-assets.index' => 'Melawat senarai aset tak alih',
            'admin.immovable-assets.show' => 'Melihat detail aset tak alih',
            'admin.immovable-assets.create' => 'Melawat borang tambah aset tak alih',
            'admin.immovable-assets.edit' => 'Melawat borang edit aset tak alih',
            
            // Reports
            'admin.reports.index' => 'Melawat halaman laporan',
            'admin.reports.assets-by-location' => 'Melawat laporan aset mengikut lokasi',
            'admin.reports.annual-summary' => 'Melawat laporan ringkasan tahunan',
            'admin.reports.movements-summary' => 'Melawat laporan ringkasan pergerakan',
            'admin.reports.inspection-schedule' => 'Melawat jadual pemeriksaan',
            'admin.reports.maintenance-schedule' => 'Melawat jadual penyelenggaraan',
            'admin.reports.asset-depreciation' => 'Melawat laporan susut nilai aset',
            
            // Settings
            'admin.masjid-surau.index' => 'Melawat senarai masjid/surau',
            'admin.masjid-surau.show' => 'Melihat detail masjid/surau',
            'admin.masjid-surau.create' => 'Melawat borang tambah masjid/surau',
            'admin.masjid-surau.edit' => 'Melawat borang edit masjid/surau',
            
            // Audit Trails
            'admin.audit-trails.index' => 'Melawat senarai log audit',
            'admin.audit-trails.show' => 'Melihat detail log audit',
            
            // Profile
            'profile.edit' => 'Melawat halaman edit profil',
        ];

        return $descriptions[$routeName] ?? 'Melawat halaman: ' . $routeName;
    }
}
