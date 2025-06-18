CREATE TABLE IF NOT EXISTS "migrations"(
  "id" integer primary key autoincrement not null,
  "migration" varchar not null,
  "batch" integer not null
);
CREATE TABLE IF NOT EXISTS "password_reset_tokens"(
  "email" varchar not null,
  "token" varchar not null,
  "created_at" datetime,
  primary key("email")
);
CREATE TABLE IF NOT EXISTS "sessions"(
  "id" varchar not null,
  "user_id" integer,
  "ip_address" varchar,
  "user_agent" text,
  "payload" text not null,
  "last_activity" integer not null,
  primary key("id")
);
CREATE INDEX "sessions_user_id_index" on "sessions"("user_id");
CREATE INDEX "sessions_last_activity_index" on "sessions"("last_activity");
CREATE TABLE IF NOT EXISTS "cache"(
  "key" varchar not null,
  "value" text not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE TABLE IF NOT EXISTS "cache_locks"(
  "key" varchar not null,
  "owner" varchar not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE TABLE IF NOT EXISTS "jobs"(
  "id" integer primary key autoincrement not null,
  "queue" varchar not null,
  "payload" text not null,
  "attempts" integer not null,
  "reserved_at" integer,
  "available_at" integer not null,
  "created_at" integer not null
);
CREATE INDEX "jobs_queue_index" on "jobs"("queue");
CREATE TABLE IF NOT EXISTS "job_batches"(
  "id" varchar not null,
  "name" varchar not null,
  "total_jobs" integer not null,
  "pending_jobs" integer not null,
  "failed_jobs" integer not null,
  "failed_job_ids" text not null,
  "options" text,
  "cancelled_at" integer,
  "created_at" integer not null,
  "finished_at" integer,
  primary key("id")
);
CREATE TABLE IF NOT EXISTS "failed_jobs"(
  "id" integer primary key autoincrement not null,
  "uuid" varchar not null,
  "connection" text not null,
  "queue" text not null,
  "payload" text not null,
  "exception" text not null,
  "failed_at" datetime not null default CURRENT_TIMESTAMP
);
CREATE UNIQUE INDEX "failed_jobs_uuid_unique" on "failed_jobs"("uuid");
CREATE TABLE IF NOT EXISTS "masjids_suraus"(
  "id" integer primary key autoincrement not null,
  "nama" varchar not null,
  "singkatan_nama" varchar not null,
  "alamat" text not null,
  "daerah" varchar not null,
  "no_telefon" varchar,
  "email" varchar,
  "status" varchar not null default 'Aktif',
  "created_at" datetime,
  "updated_at" datetime
);
CREATE TABLE IF NOT EXISTS "assets"(
  "id" integer primary key autoincrement not null,
  "masjid_surau_id" integer not null,
  "no_siri_pendaftaran" varchar not null,
  "nama_aset" varchar not null,
  "jenis_aset" varchar not null,
  "tarikh_perolehan" date not null,
  "kaedah_perolehan" varchar not null,
  "nilai_perolehan" numeric not null,
  "umur_faedah_tahunan" integer,
  "susut_nilai_tahunan" numeric,
  "lokasi_penempatan" varchar not null,
  "pegawai_bertanggungjawab_lokasi" varchar not null,
  "status_aset" varchar not null default 'Sedang Digunakan',
  "gambar_aset" text,
  "catatan" text,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("masjid_surau_id") references "masjids_suraus"("id") on delete cascade
);
CREATE UNIQUE INDEX "assets_no_siri_pendaftaran_unique" on "assets"(
  "no_siri_pendaftaran"
);
CREATE TABLE IF NOT EXISTS "asset_movements"(
  "id" integer primary key autoincrement not null,
  "asset_id" integer not null,
  "tarikh_permohonan" date not null,
  "jenis_pergerakan" varchar not null,
  "lokasi_asal" varchar not null,
  "lokasi_destinasi" varchar not null,
  "nama_peminjam_pegawai_bertanggungjawab" varchar not null,
  "tujuan_pergerakan" text not null,
  "tarikh_jangka_pulang" date,
  "tarikh_pulang_sebenar" date,
  "status_pergerakan" varchar not null default 'Dimohon',
  "pegawai_meluluskan" varchar,
  "catatan" text,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("asset_id") references "assets"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "inspections"(
  "id" integer primary key autoincrement not null,
  "asset_id" integer not null,
  "tarikh_pemeriksaan" date not null,
  "keadaan_aset" varchar not null,
  "lokasi_semasa_pemeriksaan" varchar not null,
  "cadangan_tindakan" varchar not null,
  "pegawai_pemeriksa" varchar not null,
  "catatan_pemeriksa" text,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("asset_id") references "assets"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "maintenance_records"(
  "id" integer primary key autoincrement not null,
  "asset_id" integer not null,
  "tarikh_penyelenggaraan" date not null,
  "jenis_penyelenggaraan" varchar not null,
  "butiran_kerja" text not null,
  "nama_syarikat_kontraktor" varchar,
  "kos_penyelenggaraan" numeric not null,
  "status_penyelenggaraan" varchar not null default 'Dalam Proses',
  "pegawai_bertanggungjawab" varchar not null,
  "catatan" text,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("asset_id") references "assets"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "disposals"(
  "id" integer primary key autoincrement not null,
  "asset_id" integer not null,
  "tarikh_permohonan" date not null,
  "justifikasi_pelupusan" text not null,
  "kaedah_pelupusan_dicadang" varchar not null,
  "nombor_mesyuarat_jawatankuasa" varchar,
  "tarikh_kelulusan_pelupusan" date,
  "status_pelupusan" varchar not null default 'Dimohon',
  "pegawai_pemohon" varchar not null,
  "catatan" text,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("asset_id") references "assets"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "losses_writeoffs"(
  "id" integer primary key autoincrement not null,
  "asset_id" integer not null,
  "tarikh_laporan" date not null,
  "jenis_kejadian" varchar not null,
  "sebab_kejadian" varchar not null,
  "butiran_kejadian" text not null,
  "pegawai_pelapor" varchar not null,
  "tarikh_kelulusan_hapus_kira" date,
  "status_kejadian" varchar not null default 'Dilaporkan',
  "catatan" text,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("asset_id") references "assets"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "immovable_assets"(
  "id" integer primary key autoincrement not null,
  "masjid_surau_id" integer not null,
  "nama_aset" varchar not null,
  "jenis_aset" varchar not null,
  "alamat" text,
  "no_hakmilik" varchar,
  "no_lot" varchar,
  "luas_tanah_bangunan" numeric not null,
  "tarikh_perolehan" date not null,
  "sumber_perolehan" varchar not null,
  "kos_perolehan" numeric not null,
  "keadaan_semasa" varchar not null,
  "gambar_aset" text,
  "catatan" text,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("masjid_surau_id") references "masjids_suraus"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "users"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "email" varchar not null,
  "email_verified_at" datetime,
  "password" varchar not null,
  "remember_token" varchar,
  "created_at" datetime,
  "updated_at" datetime,
  "role" varchar not null default 'Pegawai Aset',
  "masjid_surau_id" integer,
  foreign key("masjid_surau_id") references "masjids_suraus"("id") on delete set null
);
CREATE UNIQUE INDEX "users_email_unique" on "users"("email");

INSERT INTO migrations VALUES(1,'0001_01_01_000000_create_users_table',1);
INSERT INTO migrations VALUES(2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO migrations VALUES(3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO migrations VALUES(4,'2025_06_18_145634_create_masjids_suraus_table',1);
INSERT INTO migrations VALUES(5,'2025_06_18_145639_create_assets_table',1);
INSERT INTO migrations VALUES(6,'2025_06_18_145641_create_asset_movements_table',1);
INSERT INTO migrations VALUES(7,'2025_06_18_145642_create_inspections_table',1);
INSERT INTO migrations VALUES(8,'2025_06_18_145644_create_maintenance_records_table',1);
INSERT INTO migrations VALUES(9,'2025_06_18_145645_create_disposals_table',1);
INSERT INTO migrations VALUES(10,'2025_06_18_145650_create_losses_writeoffs_table',1);
INSERT INTO migrations VALUES(11,'2025_06_18_145652_create_immovable_assets_table',1);
INSERT INTO migrations VALUES(12,'2025_06_18_145653_add_role_and_masjid_surau_id_to_users_table',1);
