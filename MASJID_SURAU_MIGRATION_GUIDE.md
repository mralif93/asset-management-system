# Masjid Surau Table Migration Guide

## Overview

This guide documents the reorganization of the `masjids_suraus` table into a new, cleaner `masjid_surau` table structure with enhanced web scraping capabilities.

## Table Structure Changes

### Old Table: `masjids_suraus`
- Multiple fragmented migrations
- Inconsistent field organization
- Complex migration history

### New Table: `masjid_surau`
- Single, organized migration file
- Complete field structure in one place
- Enhanced with web scraping fields
- Better naming convention

## Complete Field List

| Field Name | Data Type | Nullable | Default | Description |
|------------|-----------|----------|---------|-------------|
| `id` | BIGINT | NOT NULL | AUTO_INCREMENT | Primary key |
| `nama` | VARCHAR(255) | NOT NULL | - | Name of masjid/surau |
| `singkatan_nama` | VARCHAR(20) | NULL | - | Abbreviation for asset codes |
| `jenis` | ENUM | NOT NULL | 'Masjid' | Type: 'Masjid' or 'Surau' |
| `kategori` | VARCHAR(100) | NULL | - | Category: Kariah, Persekutuan, Negeri, Swasta, Wakaf |
| **Address Fields** |
| `alamat_baris_1` | VARCHAR(255) | NULL | - | Address line 1 |
| `alamat_baris_2` | VARCHAR(255) | NULL | - | Address line 2 |
| `alamat_baris_3` | VARCHAR(255) | NULL | - | Address line 3 |
| `poskod` | VARCHAR(10) | NOT NULL | '00000' | Postal code |
| `bandar` | VARCHAR(100) | NOT NULL | '' | City/town |
| `negeri` | VARCHAR(100) | NOT NULL | '' | State |
| `negara` | VARCHAR(255) | NOT NULL | 'Malaysia' | Country |
| `daerah` | VARCHAR(255) | NOT NULL | '' | District |
| **Contact Information** |
| `no_telefon` | VARCHAR(20) | NULL | - | Phone number |
| `email` | VARCHAR(255) | NULL | - | Email address |
| **Management Details** |
| `imam_ketua` | VARCHAR(255) | NULL | - | Imam/head person |
| `bilangan_jemaah` | INTEGER | NULL | - | Number of congregants |
| `tahun_dibina` | INTEGER | NULL | - | Year established |
| `status` | VARCHAR(255) | NOT NULL | 'Aktif' | Active status |
| `catatan` | TEXT | NULL | - | Notes/remarks |
| **New Scraping Fields** |
| `nama_rasmi` | VARCHAR(255) | NULL | - | Official registered name |
| `kawasan` | VARCHAR(255) | NULL | - | Sub-district/local area |
| `pautan_peta` | TEXT | NULL | - | Google Maps link |
| **System Fields** |
| `created_at` | TIMESTAMP | NULL | - | Creation timestamp |
| `updated_at` | TIMESTAMP | NULL | - | Update timestamp |

**Total: 25 fields**

## Migration Files Created

### 1. Main Migration
```
database/migrations/2025_06_21_070951_create_masjid_surau_table_organized.php
```
- Creates the new organized table structure
- Includes all fields in logical groupings
- Clean, single-file approach

### 2. Data Migration
```
database/migrations/2025_06_21_071207_migrate_to_new_masjid_surau_table.php
```
- Copies data from old `masjids_suraus` to new `masjid_surau`
- Updates foreign key references
- Handles data transformation

## Model Updates

### MasjidSurau Model Changes
```php
// Updated table name
protected $table = 'masjid_surau';

// Added new fillable fields
protected $fillable = [
    // ... existing fields ...
    'nama_rasmi',
    'kawasan', 
    'pautan_peta',
];
```

## Controller Validation Updates

Updated validation rules in:
- `AuthController.php`
- `AssetController.php`
- `AdminProfileController.php`
- `ImmovableAssetController.php`
- `UserController.php`

Changed from:
```php
'masjid_surau_id' => 'required|exists:masjids_suraus,id'
```

To:
```php
'masjid_surau_id' => 'required|exists:masjid_surau,id'
```

## Enhanced Seeder with Web Scraping

### Features
- **Multi-source scraping**: Masjid, Surau, and Surau Jumaat lists
- **Robust error handling**: Graceful fallback to sample data
- **Rate limiting**: Respectful server requests
- **Data validation**: Prevents duplicate entries
- **Smart parsing**: Extracts address components and map links

### Data Sources
1. `https://e-masjid.jais.gov.my/dashboard/listmasjid`
2. `https://e-masjid.jais.gov.my/dashboard/listsurau`
3. `https://e-masjid.jais.gov.my/dashboard/listsuraujumaat`

### Fallback Data
If scraping fails, creates sample data:
- Masjid Negara (Persekutuan)
- Masjid Sultan Salahuddin Abdul Aziz (Negeri)
- Surau Al-Hidayah (Kariah)

### Dependencies
```bash
composer require symfony/dom-crawler
```

## Usage Instructions

### 1. Run Migrations
```bash
php artisan migrate
```

### 2. Seed Data
```bash
# Run the enhanced seeder
php artisan db:seed --class=MasjidSurauSeeder

# Or run all seeders
php artisan db:seed
```

### 3. Verify Data
```bash
php artisan tinker
>>> App\Models\MasjidSurau::count()
>>> App\Models\MasjidSurau::first()
```

## Benefits of New Structure

### 1. **Organized Fields**
- Logical grouping (Address, Contact, Management, etc.)
- Clear field purposes with comments
- Consistent naming conventions

### 2. **Enhanced Data Collection**
- Web scraping capabilities
- Official name tracking
- Geographic area details
- Map integration support

### 3. **Better Maintainability**
- Single migration file
- Clear field relationships
- Comprehensive documentation

### 4. **Improved Performance**
- Optimized field types
- Proper indexing structure
- Efficient data access

## Data Migration Process

1. **Backup**: Original data preserved in `masjids_suraus`
2. **Transform**: Data copied with field mapping
3. **Enhance**: New fields added for scraped data
4. **Validate**: Foreign key references updated
5. **Verify**: Data integrity confirmed

## Rollback Considerations

⚠️ **Important**: The migration is not easily reversible due to:
- Complex field transformations
- New data structure
- Foreign key changes

**Recommendation**: Keep database backups before running migrations.

## Testing

### Verify Migration Success
```bash
# Check table structure
php artisan tinker --execute="Schema::getColumnListing('masjid_surau')"

# Verify data migration
php artisan tinker --execute="App\Models\MasjidSurau::count()"

# Test relationships
php artisan tinker --execute="App\Models\User::with('masjidSurau')->first()"
```

### Test Web Scraping
```bash
# Run seeder in verbose mode
php artisan db:seed --class=MasjidSurauSeeder --verbose
```

## Troubleshooting

### Common Issues

1. **Foreign Key Errors**
   - Update validation rules in controllers
   - Check model relationships

2. **Scraping Failures**
   - Check internet connectivity
   - Verify target website availability
   - Fallback data will be used automatically

3. **Data Migration Issues**
   - Ensure old table exists
   - Check for data conflicts
   - Review migration logs

### Support Commands
```bash
# Check migration status
php artisan migrate:status

# Rollback last migration (if needed)
php artisan migrate:rollback --step=1

# Fresh migration (development only)
php artisan migrate:fresh --seed
```

## Future Enhancements

### Planned Features
1. **Advanced Scraping**: Multiple state support
2. **Data Validation**: Enhanced field validation
3. **API Integration**: External data source APIs
4. **Geocoding**: Automatic coordinate generation
5. **Image Support**: Masjid/Surau photos

### Extensibility
The new structure supports:
- Additional address fields
- Custom categories
- Extended contact information
- Social media links
- Operating hours
- Facility details

---

## Summary

The masjid_surau table reorganization provides:
- ✅ Clean, organized structure
- ✅ Enhanced data collection capabilities
- ✅ Web scraping automation
- ✅ Better maintainability
- ✅ Comprehensive documentation
- ✅ Robust error handling
- ✅ Backward compatibility

This migration establishes a solid foundation for the asset management system's location data management. 