di obrolan sebelumnya kita diskusi flow table dan flow akun untuk modul collector.

sekarang buatkan kode insert collect

database flow:

BEGIN  

1. INSERT collection_visit  2. INSERT collection_visit_attachment  3. UPSERT collector_balance  4. UPSERT collector_daily_summary  5. UPSERT collector_monthly_summary.

============================

kode view frontend


PKK User
   │
   │ users_id
   ▼
collection_visit
   │
   │ melalui usersorganization
   ▼
organization_program
   │
   ├── organization_collection_daily_summary
   │
   └── organization_collection_monthly_summary
Saat collection berhasil COMPLETED
BEGIN TRANSACTION
1. INSERT collection_visit
2. UPDATE user/PKK summary
3. UPDATE organization daily summary
4. UPDATE organization monthly summary
COMMIT

dalam 1 DB transaction:
collection_visit
       │
       ├── UPDATE users_collection_balance
       │
       ├── UPDATE users_collection_daily_summary
       │
       ├── UPDATE organization_collection_balance
       │
       ├── UPDATE organization_collection_daily_summary
       │
       └── UPDATE monthly summaries