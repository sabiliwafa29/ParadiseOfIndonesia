# 🐛 Debug Guide: Itinerary Tidak Muncul di Edit Form

## Masalah
Data itinerary tidak muncul di form edit tour package admin padahal sudah ada di database.

## Tools Debug yang Sudah Ditambahkan

### 1️⃣ Debug Visual di Browser (Edit Page)

Ketika membuka halaman edit (`/admin/tour-packages/{id}/edit`), akan muncul **kotak kuning** dengan informasi debug:

```
🐛 DEBUG INFORMATION:
- Raw DB Value: [{"title_id":"...",...}]...
- Casted Value: [{"title_id":"...",...}]...
- Old Input: EXISTS / NULL
- Is Array: YES / NO
- Array Count: 2
- JSON Decode Test: SUCCESS / FAILED
```

**Cara Cek:**
1. Buka browser
2. Navigate ke `/admin/tour-packages/{id}/edit`
3. Lihat kotak kuning di bagian atas form itinerary
4. Screenshot dan analisis nilai-nilainya

---

### 2️⃣ Browser Console Debug (Developer Tools)

Buka **Developer Tools** (F12) → Tab **Console**, akan muncul log seperti ini:

```
🐛 === ITINERARY DEBUG START ===
Initial itinerary count from PHP: 2
Itinerary data: [{...}, {...}]
Tour Package ID: 1
Raw itinerary from model: [{...}, {...}]
DOM: Found 2 itinerary items in container
DOM: Day 1 has 6 input fields
  - itinerary[0][title_id]: "Hari Pertama"
  - itinerary[0][title_en]: "First Day"
  ...
🐛 === ITINERARY DEBUG END ===
```

**Cara Cek:**
1. Buka browser
2. Tekan `F12` atau klik kanan → Inspect
3. Pilih tab **Console**
4. Refresh halaman edit
5. Lihat log yang muncul

---

### 3️⃣ Laravel Log File (Backend)

Setiap kali halaman edit dibuka, akan ada log di `storage/logs/laravel.log`:

```
[2025-11-22 12:00:00] local.INFO: === ITINERARY DEBUG ===
[2025-11-22 12:00:00] local.INFO: Raw from DB: [{"title_id":"..."}]
[2025-11-22 12:00:00] local.INFO: After casting: [{"title_id":"..."}]
[2025-11-22 12:00:00] local.INFO: Type: array
[2025-11-22 12:00:00] local.INFO: Is Array: YES
[2025-11-22 12:00:00] local.INFO: Final itinerary count: 2
```

**Cara Cek:**
```powershell
# Buka file log
notepad storage\logs\laravel.log

# Atau tail real-time (jika punya tail command)
Get-Content storage\logs\laravel.log -Wait -Tail 50
```

---

### 4️⃣ Artisan Command (Terminal)

Jalankan command khusus untuk debug:

```powershell
# Debug semua tour packages
php artisan debug:itinerary

# Debug specific package by ID
php artisan debug:itinerary 1
```

**Output:**
```
=== TOUR PACKAGE ITINERARY DEBUG ===

📦 Package ID: 1
   Name: Bali Adventure Package
   ------------------------------------------------------------
   1️⃣ RAW DB VALUE:
      Type: string
      Length: 450 chars
      Preview: [{"title_id":"Hari Pertama","title_en":"First Day"...

   2️⃣ AFTER CASTING:
      Type: array
      Is Array: YES
      Count: 3
      Keys in first item: title_id, title_en, title_zh...

      Sample Data (first item):
      ┌─────────────────┬────────────────────────────────┐
      │ Key             │ Value                          │
      ├─────────────────┼────────────────────────────────┤
      │ title_id        │ Hari Pertama - Tiba di Bali   │
      │ title_en        │ First Day - Arrival in Bali   │
      │ description_id  │ Penjemputan di bandara...      │
      └─────────────────┴────────────────────────────────┘

   3️⃣ JSON VALIDATION:
      ✅ Valid JSON
      Decoded type: array
      Decoded count: 3

   4️⃣ MODEL CASTS CHECK:
      Itinerary cast: array
   ============================================================
```

---

### 5️⃣ Test Script PHP (Direct)

Jalankan script standalone:

```powershell
php test_itinerary_debug.php
```

---

## 🔍 Checklist Debugging

### Step 1: Cek Database
```sql
-- Akses database
SELECT id, name_en, itinerary FROM tour_packages;

-- Cek apakah itinerary NULL atau berisi data
SELECT 
    id, 
    name_en, 
    itinerary IS NULL as is_null,
    LENGTH(itinerary) as json_length
FROM tour_packages;
```

**Kemungkinan:**
- ❌ `itinerary` = NULL → Data belum ada
- ❌ `itinerary` = `""` (empty string) → Data kosong
- ❌ `itinerary` = `"null"` → JSON null
- ✅ `itinerary` = `[{...}]` → Data valid

---

### Step 2: Cek Model Casting

File: `app/Models/TourPackage.php`

```php
protected $casts = [
    'itinerary' => 'array', // ✅ Harus ada ini!
];
```

**Jika tidak ada:**
```powershell
php artisan tinker
>>> $package = App\Models\TourPackage::first();
>>> $package->itinerary; // Akan return string, bukan array
```

---

### Step 3: Cek Data Type di View

Buka kotak debug kuning di browser, perhatikan:

| Nilai | Arti | Solusi |
|-------|------|--------|
| `Raw DB Value: NULL` | Tidak ada data di DB | Insert data itinerary |
| `Casted Value: NULL` | Model tidak cast dengan benar | Cek `$casts` di model |
| `Is Array: NO` | Bukan array setelah casting | Cek format JSON di DB |
| `Array Count: 0` | Array kosong | Data ada tapi kosong |
| `Array Count: 2+` | ✅ Data valid | Cek rendering DOM |

---

### Step 4: Cek Rendering DOM

Buka **Console** (F12), lihat:

```
DOM: Found 0 itinerary items in container
```

**Jika 0 items:**
- Blade loop tidak jalan
- `@foreach($existingItinerary as $index => $item)` tidak looping
- Variable `$existingItinerary` kosong

**Debug di Blade:**
```blade
@php
    dd($existingItinerary); // Lihat isi variable
@endphp
```

---

## 🛠️ Kemungkinan Masalah & Solusi

### Problem 1: Data NULL di Database
```powershell
# Solusi: Insert sample data
php artisan tinker
>>> $package = App\Models\TourPackage::first();
>>> $package->itinerary = [
...     ['title_id' => 'Hari 1', 'title_en' => 'Day 1', 'title_zh' => '第一天',
...      'description_id' => 'Desc ID', 'description_en' => 'Desc EN', 'description_zh' => 'Desc ZH']
... ];
>>> $package->save();
```

### Problem 2: Model Cast Tidak Ada
```php
// app/Models/TourPackage.php
protected $casts = [
    'itinerary' => 'array', // Tambahkan ini!
];
```

### Problem 3: JSON Invalid di Database
```sql
-- Cek apakah JSON valid
SELECT id, JSON_VALID(itinerary) as is_valid FROM tour_packages;

-- Jika tidak valid, update dengan JSON valid
UPDATE tour_packages 
SET itinerary = '[]' 
WHERE JSON_VALID(itinerary) = 0;
```

### Problem 4: PostgreSQL vs MySQL
Jika pakai **PostgreSQL**, kolom harus `jsonb` atau `json`:

```php
// Migration
$table->jsonb('itinerary')->nullable(); // Bukan 'json'
```

---

## 📊 Expected vs Actual

| Aspek | Expected | Check Point |
|-------|----------|-------------|
| DB Column Type | `json` atau `jsonb` | Migration file |
| DB Value Type | String JSON | Raw DB value |
| Model Cast | `array` | `$casts` property |
| PHP Variable Type | Array | `gettype()` |
| PHP Array Count | ≥ 1 | `count()` |
| DOM Elements | ≥ 1 `.itinerary-item` | Browser DevTools |
| Input Fields | 6 per item | Console log |
| Field Values | Not empty | Input `value` attribute |

---

## 🎯 Quick Test Procedure

1. **Run Artisan Command:**
   ```powershell
   php artisan debug:itinerary 1
   ```

2. **Check Output:**
   - Is Array: **YES** ✅
   - Count: **> 0** ✅
   - Valid JSON: **✅** ✅

3. **Open Edit Page:**
   ```
   http://localhost:8000/admin/tour-packages/1/edit
   ```

4. **Check Yellow Debug Box:**
   - Array Count: **2** ✅

5. **Check Browser Console (F12):**
   - Found X itinerary items ✅
   - Each has 6 fields ✅

6. **Check Actual Form:**
   - Apakah input fields terisi? ✅

---

## 📝 Report Template

Jika masih tidak muncul, screenshot dan share:

```
=== DEBUG REPORT ===

1. Artisan Command Output:
   [paste screenshot]

2. Yellow Debug Box:
   Raw DB Value: ...
   Casted Value: ...
   Is Array: ...
   Array Count: ...

3. Browser Console:
   Initial itinerary count: ...
   DOM: Found X items: ...

4. Laravel Log (last 10 lines):
   [paste log]

5. Screenshot form yang kosong:
   [attach screenshot]
```

---

## ✅ Success Indicators

Jika semua berjalan baik, Anda akan lihat:

1. ✅ Kotak kuning: "Array Count: 2" (atau lebih)
2. ✅ Console: "DOM: Found 2 itinerary items"
3. ✅ Form: Input fields terisi dengan data
4. ✅ Log: "Final itinerary count: 2"

---

**Happy Debugging! 🚀**
