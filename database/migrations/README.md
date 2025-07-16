# Database Migrations

This directory contains all database migrations for the Asset Management System. Each migration file represents one table in the database, organized in sequential order to maintain proper dependencies.

## Migration Files

### Core System Tables
1. `0001_create_users_table.php`
   - User accounts and authentication
   - Role management (Admin/Asset Officer)
   - Profile information

2. `0002_create_masjid_surau_table.php`
   - Location management
   - Address and contact information
   - Institution details

### Asset Management Tables
3. `0003_create_assets_table.php`
   - Movable assets registration
   - Asset details and tracking
   - Value and warranty information

4. `0004_create_asset_movements_table.php`
   - Asset transfer and loan tracking
   - Movement approval workflow
   - Location history

5. `0005_create_inspections_table.php`
   - Asset condition monitoring
   - Inspection schedules
   - Condition reports

6. `0006_create_maintenance_records_table.php`
   - Maintenance history
   - Service provider details
   - Cost tracking

7. `0007_create_disposals_table.php`
   - Asset disposal workflow
   - Disposal approvals
   - Value assessment

8. `0008_create_losses_writeoffs_table.php`
   - Lost asset documentation
   - Police report details
   - Write-off approvals

9. `0009_create_immovable_assets_table.php`
   - Land and building assets
   - Property documentation
   - Value assessment

### System Support Tables
10. `0010_create_audit_trails_table.php`
    - System activity logging
    - Change tracking
    - User action history

11. `0011_create_system_tables.php`
    - Cache tables
    - Job queues
    - Session management

## Migration Order

The migrations are numbered sequentially to ensure proper table creation order and maintain foreign key constraints. The sequence is important because:

1. Users table must exist before any tables with user foreign keys
2. Masjid/Surau table must exist before asset tables
3. Assets table must exist before related tables (movements, inspections, etc.)
4. Audit trails can be created after all auditable tables

## Running Migrations

```bash
# Fresh installation
php artisan migrate

# Refresh database (caution: deletes all data)
php artisan migrate:fresh

# Rollback last batch
php artisan migrate:rollback

# Reset and re-run all migrations
php artisan migrate:reset
php artisan migrate
```

## Foreign Key Dependencies

- Users → Masjid/Surau
- Assets → Masjid/Surau
- Asset Movements → Assets, Users
- Inspections → Assets
- Maintenance Records → Assets, Users
- Disposals → Assets, Users
- Losses/Write-offs → Assets, Users
- Immovable Assets → Masjid/Surau
- Audit Trails → Users

## Data Types Standardization

- Primary Keys: `id` (bigIncrements)
- Foreign Keys: `*_id` (unsignedBigInteger)
- Dates: `date` or `datetime`
- Money: `decimal(10,2)` or `decimal(15,2)`
- Text: `string` (VARCHAR), `text` (TEXT)
- JSON: `json` for complex data
- Status: `string` with default values
- Timestamps: `created_at`, `updated_at` (automatic)

## Best Practices

1. Always backup data before running migrations in production
2. Test migrations in development environment first
3. Use meaningful table and column names
4. Add appropriate indexes for frequently queried columns
5. Set appropriate foreign key actions (cascade, set null)
6. Include descriptive comments for complex fields
7. Maintain consistent naming conventions

## Seeding

After running migrations, seed the database with initial data:

```bash
# Run all seeders
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=MasjidSurauSeeder
``` 