# 📊 Asset Management System - Database Documentation

## 🏗️ Database Overview

The Asset Management System uses SQLite database with **19 tables** managing assets, users, locations, and various asset-related operations for Malaysian Masjid and Surau institutions.

### 📈 Database Statistics
- **Total Tables**: 19
- **Total Records**: ~15,000+ records
- **Main Entities**: 10 core business tables
- **System Tables**: 9 Laravel framework tables

---

## 🗃️ Core Database Tables

### 1. 👥 **USERS Table**
**Purpose**: Manages system users (administrators and asset officers)

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | INTEGER | PRIMARY KEY | Unique user identifier |
| `name` | VARCHAR | NOT NULL | Full name of the user |
| `email` | VARCHAR | NOT NULL, UNIQUE | Email address for login |
| `email_verified_at` | DATETIME | NULL | Email verification timestamp |
| `password` | VARCHAR | NOT NULL | Encrypted password |
| `remember_token` | VARCHAR | NULL | Laravel remember token |
| `role` | VARCHAR | NOT NULL, DEFAULT 'Asset Officer' | User role (admin/Asset Officer) |
| `masjid_surau_id` | INTEGER | NULL, FK | Associated masjid/surau |
| `phone` | VARCHAR | NULL | Contact phone number |
| `position` | VARCHAR | NULL | Job position/title |
| `created_at` | DATETIME | NULL | Record creation timestamp |
| `updated_at` | DATETIME | NULL | Last update timestamp |

**Foreign Keys**:
- `masjid_surau_id` → `masjid_surau(id)`

**Current Records**: 105 users

---

### 2. 🕌 **MASJID_SURAU Table**
**Purpose**: Stores information about Masjid and Surau locations

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | INTEGER | PRIMARY KEY | Unique location identifier |
| `nama` | VARCHAR | NOT NULL | Official name |
| `singkatan_nama` | VARCHAR | NULL | Name abbreviation |
| `jenis` | VARCHAR | NOT NULL, DEFAULT 'Masjid' | Type (Masjid/Surau/Surau Jumaat) |
| `kategori` | VARCHAR | NULL | Category classification |
| `alamat_baris_1` | VARCHAR | NULL | Address line 1 |
| `alamat_baris_2` | VARCHAR | NULL | Address line 2 |
| `alamat_baris_3` | VARCHAR | NULL | Address line 3 |
| `poskod` | VARCHAR | NOT NULL, DEFAULT '00000' | Postal code |
| `bandar` | VARCHAR | NOT NULL, DEFAULT '' | City/Town |
| `negeri` | VARCHAR | NOT NULL, DEFAULT '' | State |
| `negara` | VARCHAR | NOT NULL, DEFAULT 'Malaysia' | Country |
| `daerah` | VARCHAR | NOT NULL, DEFAULT '' | District |
| `no_telefon` | VARCHAR | NULL | Contact phone |
| `email` | VARCHAR | NULL | Contact email |
| `imam_ketua` | VARCHAR | NULL | Head imam/leader |
| `bilangan_jemaah` | INTEGER | NULL | Congregation size |
| `tahun_dibina` | INTEGER | NULL | Year established |
| `status` | VARCHAR | NOT NULL, DEFAULT 'Active' | Status (Active/Inactive) |
| `catatan` | TEXT | NULL | Additional notes |
| `nama_rasmi` | VARCHAR | NULL | Official registered name |
| `kawasan` | VARCHAR | NULL | Area/Region |
| `pautan_peta` | TEXT | NULL | Map link URL |
| `created_at` | DATETIME | NULL | Record creation timestamp |
| `updated_at` | DATETIME | NULL | Last update timestamp |

**Current Records**: 2,509 locations
- **419 Masjid**
- **1,982 Surau** 
- **108 Surau Jumaat**

---

### 3. 🏢 **ASSETS Table**
**Purpose**: Manages movable assets (computers, furniture, equipment)

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | INTEGER | PRIMARY KEY | Unique asset identifier |
| `masjid_surau_id` | INTEGER | NOT NULL, FK | Location of asset |
| `no_siri_pendaftaran` | VARCHAR | NOT NULL | Asset registration number |
| `nama_aset` | VARCHAR | NOT NULL | Asset name |
| `jenis_aset` | VARCHAR | NOT NULL | Asset type/category |
| `tarikh_perolehan` | DATE | NOT NULL | Acquisition date |
| `kaedah_perolehan` | VARCHAR | NOT NULL | Acquisition method |
| `nilai_perolehan` | NUMERIC | NOT NULL | Acquisition value |
| `umur_faedah_tahunan` | INTEGER | NULL | Useful life (years) |
| `susut_nilai_tahunan` | NUMERIC | NULL | Annual depreciation |
| `lokasi_penempatan` | VARCHAR | NOT NULL | Physical location |
| `pegawai_bertanggungjawab_lokasi` | VARCHAR | NOT NULL | Responsible officer |
| `status_aset` | VARCHAR | NOT NULL, DEFAULT 'In Use' | Asset status |
| `gambar_aset` | TEXT | NULL | Asset images (JSON) |
| `catatan` | TEXT | NULL | Additional notes |
| `created_at` | DATETIME | NULL | Record creation timestamp |
| `updated_at` | DATETIME | NULL | Last update timestamp |

**Foreign Keys**:
- `masjid_surau_id` → `masjid_surau(id)`

**Asset Status Values**:
- `In Use` (Sedang Digunakan)
- `Not In Use` (Tidak Digunakan)
- `Under Repair` (Dalam Pembaikan)
- `Disposed` (Dilupuskan)

**Current Records**: 8 assets

---

### 4. 🏗️ **IMMOVABLE_ASSETS Table**
**Purpose**: Manages immovable assets (land, buildings)

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | INTEGER | PRIMARY KEY | Unique asset identifier |
| `masjid_surau_id` | INTEGER | NOT NULL, FK | Location of asset |
| `nama_aset` | VARCHAR | NOT NULL | Asset name |
| `jenis_aset` | VARCHAR | NOT NULL | Asset type |
| `alamat` | TEXT | NULL | Asset address |
| `no_hakmilik` | VARCHAR | NULL | Title deed number |
| `no_lot` | VARCHAR | NULL | Lot number |
| `luas_tanah_bangunan` | NUMERIC | NOT NULL | Land/building area |
| `tarikh_perolehan` | DATE | NOT NULL | Acquisition date |
| `sumber_perolehan` | VARCHAR | NOT NULL | Acquisition source |
| `kos_perolehan` | NUMERIC | NOT NULL | Acquisition cost |
| `keadaan_semasa` | VARCHAR | NOT NULL | Current condition |
| `gambar_aset` | TEXT | NULL | Asset images (JSON) |
| `catatan` | TEXT | NULL | Additional notes |
| `created_at` | DATETIME | NULL | Record creation timestamp |
| `updated_at` | DATETIME | NULL | Last update timestamp |

**Foreign Keys**:
- `masjid_surau_id` → `masjid_surau(id)`

**Current Records**: 12,598 immovable assets

---

### 5. 🔄 **ASSET_MOVEMENTS Table**
**Purpose**: Tracks asset movements, transfers, and borrowing

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | INTEGER | PRIMARY KEY | Unique movement identifier |
| `asset_id` | INTEGER | NOT NULL, FK | Asset being moved |
| `user_id` | INTEGER | NULL, FK | User requesting movement |
| `tarikh_permohonan` | DATE | NOT NULL | Application date |
| `jenis_pergerakan` | VARCHAR | NOT NULL | Movement type |
| `lokasi_asal` | VARCHAR | NOT NULL | Source location |
| `lokasi_destinasi` | VARCHAR | NOT NULL | Destination location |
| `nama_peminjam_pegawai_bertanggungjawab` | VARCHAR | NOT NULL | Responsible person |
| `sebab_pergerakan` | TEXT | NOT NULL | Movement reason |
| `tarikh_pergerakan` | DATE | NULL | Actual movement date |
| `tarikh_jangka_pulangan` | DATE | NULL | Expected return date |
| `tarikh_pulang_sebenar` | DATE | NULL | Actual return date |
| `tarikh_kepulangan` | DATETIME | NULL | Return timestamp |
| `status_pergerakan` | VARCHAR | NOT NULL, DEFAULT 'pending_approval' | Movement status |
| `diluluskan_oleh` | INTEGER | NULL, FK | Approver user ID |
| `tarikh_kelulusan` | DATETIME | NULL | Approval timestamp |
| `sebab_penolakan` | TEXT | NULL | Rejection reason |
| `catatan_pergerakan` | TEXT | NULL | Additional notes |
| `created_at` | DATETIME | NULL | Record creation timestamp |
| `updated_at` | DATETIME | NULL | Last update timestamp |

**Foreign Keys**:
- `asset_id` → `assets(id)`
- `user_id` → `users(id)`
- `diluluskan_oleh` → `users(id)`

**Movement Types**:
- `Transfer` (Pemindahan)
- `Borrowing` (Peminjaman)
- `Return` (Pengembalian)

**Status Values**:
- `pending_approval` (menunggu_kelulusan)
- `approved` (diluluskan)
- `rejected` (ditolak)

**Current Records**: 26 movements

---

### 6. 🔍 **INSPECTIONS Table**
**Purpose**: Asset inspection records and maintenance scheduling

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | INTEGER | PRIMARY KEY | Unique inspection identifier |
| `asset_id` | INTEGER | NOT NULL, FK | Asset being inspected |
| `tarikh_pemeriksaan` | DATE | NOT NULL | Inspection date |
| `kondisi_aset` | VARCHAR | NOT NULL | Asset condition |
| `tindakan_diperlukan` | VARCHAR | NOT NULL | Required action |
| `nama_pemeriksa` | VARCHAR | NOT NULL | Inspector name |
| `catatan_pemeriksaan` | TEXT | NULL | Inspection notes |
| `tarikh_pemeriksaan_akan_datang` | DATE | NULL | Next inspection date |
| `gambar_pemeriksaan` | TEXT | NULL | Inspection images (JSON) |
| `created_at` | DATETIME | NULL | Record creation timestamp |
| `updated_at` | DATETIME | NULL | Last update timestamp |

**Foreign Keys**:
- `asset_id` → `assets(id)`

**Condition Values**:
- `Good` (Baik)
- `Satisfactory` (Memuaskan)
- `Needs Attention` (Memerlukan Perhatian)
- `Critical` (Kritikal)

**Current Records**: 25 inspections

---

### 7. 🔧 **MAINTENANCE_RECORDS Table**
**Purpose**: Asset maintenance and repair records

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | INTEGER | PRIMARY KEY | Unique maintenance identifier |
| `asset_id` | INTEGER | NOT NULL, FK | Asset being maintained |
| `user_id` | INTEGER | NULL, FK | User requesting maintenance |
| `tarikh_penyelenggaraan` | DATE | NOT NULL | Maintenance date |
| `jenis_penyelenggaraan` | VARCHAR | NOT NULL | Maintenance type |
| `butiran_kerja` | TEXT | NOT NULL | Work details |
| `nama_syarikat_kontraktor` | VARCHAR | NULL | Contractor company |
| `penyedia_perkhidmatan` | VARCHAR | NULL | Service provider |
| `kos_penyelenggaraan` | NUMERIC | NOT NULL | Maintenance cost |
| `status_penyelenggaraan` | VARCHAR | NOT NULL, DEFAULT 'In Progress' | Status |
| `pegawai_bertanggungjawab` | VARCHAR | NOT NULL | Responsible officer |
| `catatan` | TEXT | NULL | General notes |
| `catatan_penyelenggaraan` | TEXT | NULL | Maintenance notes |
| `tarikh_penyelenggaraan_akan_datang` | DATE | NULL | Next maintenance date |
| `gambar_penyelenggaraan` | TEXT | NULL | Maintenance images (JSON) |
| `created_at` | DATETIME | NULL | Record creation timestamp |
| `updated_at` | DATETIME | NULL | Last update timestamp |

**Foreign Keys**:
- `asset_id` → `assets(id)`
- `user_id` → `users(id)`

**Maintenance Types**:
- `Preventive` (Pencegahan)
- `Corrective` (Pembaikan)
- `Emergency` (Kecemasan)

**Status Values**:
- `In Progress` (Dalam Proses)
- `Completed` (Selesai)
- `Postponed` (Tertunda)

**Current Records**: 28 maintenance records

---

### 8. 🗑️ **DISPOSALS Table**
**Purpose**: Asset disposal and write-off management

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | INTEGER | PRIMARY KEY | Unique disposal identifier |
| `asset_id` | INTEGER | NOT NULL, FK | Asset being disposed |
| `user_id` | INTEGER | NULL, FK | User requesting disposal |
| `tarikh_permohonan` | DATE | NOT NULL | Application date |
| `tarikh_pelupusan` | DATE | NULL | Disposal date |
| `justifikasi_pelupusan` | TEXT | NOT NULL | Disposal justification |
| `sebab_pelupusan` | VARCHAR | NULL | Disposal reason |
| `kaedah_pelupusan_dicadang` | VARCHAR | NOT NULL | Proposed disposal method |
| `kaedah_pelupusan` | VARCHAR | NULL | Actual disposal method |
| `nilai_pelupusan` | NUMERIC | NULL | Disposal value |
| `nilai_baki` | NUMERIC | NULL | Remaining value |
| `nombor_mesyuarat_jawatankuasa` | VARCHAR | NULL | Committee meeting number |
| `tarikh_kelulusan_pelupusan` | DATE | NULL | Disposal approval date |
| `status_pelupusan` | VARCHAR | NOT NULL, DEFAULT 'Requested' | Disposal status |
| `status_kelulusan` | VARCHAR | NOT NULL, DEFAULT 'pending' | Approval status |
| `pegawai_pemohon` | VARCHAR | NOT NULL | Requesting officer |
| `diluluskan_oleh` | INTEGER | NULL, FK | Approver user ID |
| `tarikh_kelulusan` | DATE | NULL | Approval date |
| `sebab_penolakan` | TEXT | NULL | Rejection reason |
| `gambar_pelupusan` | TEXT | NULL | Disposal images (JSON) |
| `catatan` | TEXT | NULL | Additional notes |
| `created_at` | DATETIME | NULL | Record creation timestamp |
| `updated_at` | DATETIME | NULL | Last update timestamp |

**Foreign Keys**:
- `asset_id` → `assets(id)`
- `user_id` → `users(id)`
- `diluluskan_oleh` → `users(id)`

**Disposal Methods**:
- `Sale` (Jualan)
- `Donation` (Derma)
- `Disposal` (Pelupusan)
- `Trade-in` (Tukar Ganti)

**Current Records**: 4 disposals

---

### 9. ⚠️ **LOSSES_WRITEOFFS Table**
**Purpose**: Asset loss and write-off records

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | INTEGER | PRIMARY KEY | Unique loss identifier |
| `asset_id` | INTEGER | NOT NULL, FK | Lost/written-off asset |
| `tarikh_laporan` | DATE | NOT NULL | Report date |
| `jenis_kejadian` | VARCHAR | NOT NULL | Incident type |
| `sebab_kejadian` | VARCHAR | NOT NULL | Incident cause |
| `butiran_kejadian` | TEXT | NOT NULL | Incident details |
| `pegawai_pelapor` | VARCHAR | NOT NULL | Reporting officer |
| `nilai_kehilangan` | NUMERIC | NOT NULL, DEFAULT '0' | Loss value |
| `laporan_polis` | VARCHAR | NULL | Police report number |
| `dokumen_kehilangan` | TEXT | NULL | Loss documents (JSON) |
| `tarikh_kelulusan_hapus_kira` | DATE | NULL | Write-off approval date |
| `status_kejadian` | VARCHAR | NOT NULL, DEFAULT 'Reported' | Incident status |
| `diluluskan_oleh` | INTEGER | NULL, FK | Approver user ID |
| `sebab_penolakan` | TEXT | NULL | Rejection reason |
| `catatan` | TEXT | NULL | Additional notes |
| `created_at` | DATETIME | NULL | Record creation timestamp |
| `updated_at` | DATETIME | NULL | Last update timestamp |

**Foreign Keys**:
- `asset_id` → `assets(id)`
- `diluluskan_oleh` → `users(id)`

**Incident Types**:
- `Loss` (Kehilangan)
- `Theft` (Kecurian)
- `Damage` (Kerosakan)
- `Fire` (Kebakaran)

**Current Records**: 5 loss records

---

### 10. 📋 **AUDIT_TRAILS Table**
**Purpose**: System activity logging and audit tracking

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | INTEGER | PRIMARY KEY | Unique audit identifier |
| `user_id` | INTEGER | NULL, FK | User performing action |
| `user_name` | VARCHAR | NULL | User name snapshot |
| `user_email` | VARCHAR | NULL | User email snapshot |
| `user_role` | VARCHAR | NULL | User role snapshot |
| `action` | VARCHAR | NOT NULL | Action performed |
| `model_type` | VARCHAR | NULL | Model class name |
| `model_id` | INTEGER | NULL | Model record ID |
| `model_name` | VARCHAR | NULL | Model name/title |
| `ip_address` | VARCHAR | NULL | User IP address |
| `user_agent` | TEXT | NULL | Browser user agent |
| `method` | VARCHAR | NULL | HTTP method |
| `url` | TEXT | NULL | Request URL |
| `route_name` | TEXT | NULL | Laravel route name |
| `old_values` | TEXT | NULL | Previous values (JSON) |
| `new_values` | TEXT | NULL | New values (JSON) |
| `description` | TEXT | NULL | Action description |
| `event_type` | VARCHAR | NULL | Event type |
| `status` | VARCHAR | NOT NULL, DEFAULT 'success' | Action status |
| `error_message` | TEXT | NULL | Error details |
| `additional_data` | TEXT | NULL | Extra data (JSON) |
| `created_at` | DATETIME | NULL | Record creation timestamp |
| `updated_at` | DATETIME | NULL | Last update timestamp |

**Foreign Keys**:
- `user_id` → `users(id)`

**Action Types**:
- `created` (Record Creation)
- `updated` (Record Update)
- `deleted` (Record Deletion)
- `login` (User Login)
- `logout` (User Logout)
- `page_view` (Page Access)

**Current Records**: 2,633 audit entries

---

## 🔗 Database Relationships

### Primary Relationships

```
masjid_surau (1) ──→ (∞) users
masjid_surau (1) ──→ (∞) assets
masjid_surau (1) ──→ (∞) immovable_assets

assets (1) ──→ (∞) asset_movements
assets (1) ──→ (∞) inspections
assets (1) ──→ (∞) maintenance_records
assets (1) ──→ (∞) disposals
assets (1) ──→ (∞) losses_writeoffs

users (1) ──→ (∞) asset_movements (requester)
users (1) ──→ (∞) asset_movements (approver)
users (1) ──→ (∞) maintenance_records
users (1) ──→ (∞) disposals (requester)
users (1) ──→ (∞) disposals (approver)
users (1) ──→ (∞) losses_writeoffs (approver)
users (1) ──→ (∞) audit_trails
```

---

## 🛠️ Laravel Framework Tables

### System Tables
- **migrations**: Database migration tracking
- **password_reset_tokens**: Password reset functionality
- **sessions**: User session management
- **cache** & **cache_locks**: Application caching
- **jobs**, **job_batches**, **failed_jobs**: Queue management

---

## 📊 Data Statistics Summary

| Table | Records | Purpose |
|-------|---------|---------|
| `masjid_surau` | 2,509 | Location master data |
| `immovable_assets` | 12,598 | Land and building assets |
| `audit_trails` | 2,633 | System activity logs |
| `users` | 105 | System users |
| `maintenance_records` | 28 | Asset maintenance |
| `asset_movements` | 26 | Asset transfers/loans |
| `inspections` | 25 | Asset inspections |
| `assets` | 8 | Movable assets |
| `losses_writeoffs` | 5 | Asset losses |
| `disposals` | 4 | Asset disposals |

**Total Business Records**: ~18,000+

---

## 🔐 Security Features

### Data Protection
- **Foreign Key Constraints**: Ensure data integrity
- **Audit Trail**: Complete activity logging
- **User Authentication**: Laravel Breeze integration
- **Role-Based Access**: Admin and Asset Officer roles
- **Password Encryption**: Bcrypt hashing

### Backup Considerations
- **SQLite Database**: Single file backup
- **Migration Files**: Schema version control
- **Seeder Files**: Test data recreation

---

## 📝 Development Notes

### Migration History
1. **Initial Setup** (2025-06-18): Core tables creation
2. **Structure Updates** (2025-06-19/20): Field additions and corrections
3. **Data Migration** (2025-06-21): Masjid/Surau data consolidation
4. **Constraint Fixes** (2025-06-23): Foreign key corrections

### Key Features
- **Real Data Integration**: 2,509 actual Masjid/Surau from JAIS
- **Comprehensive Auditing**: All actions logged
- **Asset Lifecycle**: Complete asset management workflow
- **Approval Workflows**: Multi-level approval processes
- **Rich Media Support**: Image attachments for assets

---

*This documentation reflects the current database structure as of June 2025. For technical support or schema modifications, consult the development team.* 