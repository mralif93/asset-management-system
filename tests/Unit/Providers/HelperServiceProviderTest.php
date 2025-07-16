<?php

namespace Tests\Unit\Providers;

use App\Helpers\AssetRegistrationNumber;
use App\Providers\HelperServiceProvider;
use Tests\TestCase;

class HelperServiceProviderTest extends TestCase
{
    public function testHelperServiceProviderRegistration()
    {
        // Create a new instance of the provider
        $provider = new HelperServiceProvider($this->app);
        
        // Register the provider
        $provider->register();
        
        // Boot the provider
        $provider->boot();
        
        // Verify that the AssetRegistrationNumber helper is available
        $this->assertTrue(class_exists(AssetRegistrationNumber::class));
        
        // Verify that the helper functions work as expected
        $abbreviations = AssetRegistrationNumber::getAssetTypeAbbreviations();
        $this->assertIsArray($abbreviations);
        $this->assertArrayHasKey('Harta Modal', $abbreviations);
    }
} 