# GoDaddy Hosting Par Website Upload Karne Ka Complete Guide
## (Khushi Enterprises B2B Wholesale Website)

Aapki website production-ready hai aur GoDaddy shared hosting / cPanel ke liye optimize ki gayi hai. Isme kisi permanent Node.js server ki zaroorat nahi hai. Yeh direct **Apache + PHP + MySQL** (aur automatic JSON fallback) par chalti hai.

---

### Method 1: GoDaddy cPanel File Manager (Sabse Aasan Tarika — 5 Minutes)

#### Step 1: Files Ka ZIP Banayein
1. Apne computer par `C:\Users\Admin\.gemini\antigravity\scratch\khushi-enterprises` folder me jayein.
2. Is folder ke andar ki sabhi files aur folders select karein:
   - `index.html`
   - `.htaccess`
   - `robots.txt`
   - `sitemap.xml`
   - `database.sql`
   - `assets/` (jisme images, css, js, docs hain)
   - `api/`
   - `config/`
   - `admin/`
3. Right-click karke **Compress to ZIP file** karein (Name: `khushi-website.zip`).

#### Step 2: GoDaddy cPanel Me Login Karein
1. [godaddy.com](https://godaddy.com) par login karein.
2. **My Products** > **Web Hosting** > apne hosting plan ke samne **Manage** par click karein.
3. **cPanel Admin** button par click karke cPanel open karein.

#### Step 3: File Manager Me Upload Karein
1. cPanel me **File Manager** par click karein.
2. Left side se **public_html** directory open karein.
   *(Agar isme pehle se koi default file jaise default.html ho, to use delete kar dein).*
3. Top menu me **Upload** par click karein aur `khushi-website.zip` upload karein.
4. Upload complete hone ke baad, `khushi-website.zip` par right-click karke **Extract** select karein.
5. Files extract hone ke baad zip file delete kar sakte hain.

> [!TIP]
> **Website Abhi Chalu Ho Gayi!**
> Aapki website bina MySQL database ke bhi turant live ho jati hai, kyunki isme automatic JSON database fallback diya gaya hai!

---

### Step 4 (Optional): MySQL Database Setup (Agar Admin Panel Me Data Save Rakhna Ho)

Agar aap chahein to GoDaddy me 2 minute me database connect kar sakte hain:

1. **cPanel Home** par jayein > **MySQL Database Wizard** open karein.
2. **Step 1: Create A Database**: Database name dalein (e.g. `khushi_db`).
3. **Step 2: Create Database Users**: Username aur ek strong password banayein (e.g. `khushi_user` aur password).
4. **Step 3: Add User to Database**: **ALL PRIVILEGES** checkbox tick karein aur Next karein.
5. **phpMyAdmin Open Karein**:
   - cPanel me **phpMyAdmin** par click karein.
   - Left side se apna banaya hua database select karein.
   - Top menu me **Import** tab par click karein.
   - `database.sql` file choose karein aur niche **Import / Go** par click karein. (Tables auto-create ho jayengi).
6. **config/db.php Update Karein**:
   - File Manager me `config/db.php` file edit karein aur apna DB Name, DB User aur Password enter kar dein:
   ```php
   define('DB_NAME', 'your_cpanel_username_khushi_db');
   define('DB_USER', 'your_cpanel_username_khushi_user');
   define('DB_PASS', 'YourPasswordHere');
   ```

---

### Step 5: Admin Panel Login (Customer Enquiries Dekhne Ke Liye)
- Browser me open karein: `https://yourdomain.com/admin/`
- Default Password: `khushi2026`
- Yahan aap website se aayi hui sabhi wholesale requirements dekh sakte hain, WhatsApp par ek-click me reply kar sakte hain, aur Excel/CSV me export kar sakte hain.
- Password change karne ke liye `admin/login.php` aur `admin/index.php` me `khushi2026` ki jagah apna naya password likh dein.

---

### Summary Checklist:
- [x] Responsive on all mobile phones & desktops
- [x] Official Dark Navy & Gold logo integrated
- [x] All 89 real catalogue products extracted with high-res photos
- [x] Direct WhatsApp ordering with pre-filled messages on `+91 80506 53180` and `+91 81496 65755`
- [x] Exact shop address: `Inam Nagar, Betal Nagar, Kondhwa, Pune, Maharashtra 411048`
- [x] Google Maps link & embed integrated
- [x] Downloadable 89-page Wholesale PDF catalogue button
- [x] No minimum order restriction highlighted
- [x] Delivery across Pune and Maharashtra transport dispatch
- [x] Contact form with PHP backend & fallback
- [x] Sticky bottom mobile action bar `[WhatsApp] [Call] [Directions] [PDF]`
