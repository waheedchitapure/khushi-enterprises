# Khushi Enterprises — B2B Wholesale Website Context & Architecture

> **Purpose of this document**: When opening this repository in Antigravity (at the office or home), this document provides full background context, business identity, architectural decisions, and operational instructions.

---

## 🏢 Business Identity & Overview

- **Business Name**: Khushi Enterprises
- **Business Type**: B2B Wholesale Supplier & Distributor
- **Core Industry**: Plumbing, Sanitaryware, Bathroom Fittings (CP Taps & Showers), PVC & Garden Pipes, Chemical Drain Cleaners, Flush Tanks & Cistern Fittings, Industrial/Plumbing Valves, Hardware Fasteners & Gitti, PVC Electrical Conduit Fittings.
- **Physical Address**: Inam Nagar, Betal Nagar, Kondhwa, Pune, Maharashtra 411048, India.
- **Phone Numbers**:
  - `+91 80506 53180` (Primary Calling & WhatsApp Ordering)
  - `+91 81496 65755` (Secondary Calling & WhatsApp Ordering)
- **Google Business / Map Location**: [Google Maps Link](https://share.google/mRDoUE0KR1S2oK6mw)
- **Target Audience**: Retail hardware shops, sanitaryware dealers, building contractors, plumbers, and commercial purchasers.
- **Supply / Delivery Coverage**:
  - **Local Pune & PCMC**: Kondhwa, Camp, Hadapsar, Katraj, Swargate, Market Yard, Pimpri-Chinchwad, Wagholi, Kothrud, Hinjawadi.
  - **Outside Pune / Maharashtra-wide**: Outstation transport booking and dispatch across all Maharashtra districts (Satara, Solapur, Kolhapur, Ahmednagar, etc.) and neighboring states.

---

## 🎨 Branding & Design System

The visual identity is strictly aligned with the authentic circular "KE" Khushi Enterprises logo:
- **Primary Brand Colors**:
  - Dark Navy Blue: `#0a1d37`, `#071527`, `#0f274a`
  - Rich Warm Gold: `#c69234`, `#dcb059`, `#faf6ee`
- **Backgrounds**: Clean off-white and soft neutrals (`#ffffff`, `#f8fafc`, `#f1f5f9`).
- **Tone & Copy**:
  - Corporate, established, trustworthy, large-firm distributor feel.
  - Simple, accessible English paired with high-impact Roman Hindi taglines (e.g., *"Apki Dukaan Ka Reliable Wholesale Partner"*, *"Quality Maal. Best Rates. Reliable Supply."*, *"Bulk Mein Order Karo, Better Rates Pao."*).
  - **Rule**: STRICTLY Roman/Latin characters. NO Unicode Devanagari script.

---

## 📦 Product Inventory & Catalogue (89 Items Extracted)

All product photography was extracted directly from the business owner's 89-page WhatsApp catalogue (`DO22C-20260615-WA0002..pdf`) into `assets/images/products/product_01.jpg` to `product_89.jpg`.

### Categories:
1. **Bath Taps & Showers (`bath-fittings`)**: 2-way bib cocks, angle valves, single-lever pillar cocks, high-arc swan necks, ultra-slim stainless steel rain showers, chrome health faucets/jet sprays (Brands: *Ruhe, Alton, ZAP, Krihe, Anmex, Cliqun*).
2. **Drain & Waste Systems (`waste-drain`)**: Stainless steel kitchen sink waste couplings with strainer baskets, brass half-thread basin couplings, Lipka/Curovit cockroach trap jalis, flexible sink waste pipes, washing machine inlet/drain hoses.
3. **Pipes & Hoses (`pipes-hoses`)**: Multi-color braided garden pipe rolls, King heavy-duty reinforced hose rolls, green spiral suction pipes, clear water level tubes, hose joiners & spray nozzles.
4. **Cleaners & Chemicals (`drain-cleaners`)**: Kadam Dr. Flow instant drain cleaner sachets, Chock-up liquid unblocker bottles, Rich Fox 98% pure caustic soda flakes (1kg), Cosmic bleaching powder (1kg), spring wire drain claw unblockers, vacuum suction plungers, safety rubber gloves.
5. **Cistern & Seat Covers (`cistern-toilet`)**: Slim wall-mount PVC dual-flush cistern tanks, Belmonte vertical float ball cock mechanisms, universal ball float assemblies, PVC L-bend pipes, heavy-duty commode seat covers, Jexon siphon washers, silicone flush gaskets.
6. **Valves & Plumbing Spares (`valves-hardware`)**: Heavy forged brass swing check valves (NRV), full-bore brass ball valves with vinyl grip, UPVC solvent-weld ball valves, brass ceramic disc tap spindle cartridges, brass & chrome hex extension nipples, Allen key sets (1.5mm–10mm), grub screws.
7. **Hardware & Electrical Conduit (`hardware` / `electrical-conduit`)**: Mayur Plast heavy plastic construction ghamela/tasla, nylon wall plugs (gitti), hardwood roll plugs, Ivy Grip washable nano tape, PVC conduit pipes, circular 4-way deep junction boxes, long bends, tees, fan box covers, GI pipe saddle clamps.

---

## ⚙️ Key Technical Features

1. **Mobile-First Responsive Layout**:
   - 90%+ of wholesale customers access via mobile.
   - Sticky bottom action bar on mobile: `[ 🟢 WhatsApp ] [ 📞 Call Now ] [ 📍 Directions ] [ 📥 PDF List ]`.
   - Touch-friendly tap targets, safe-area inset support, responsive from 320px width upwards.
2. **Interactive Catalogue & Live Search**:
   - Fast client-side search across name, category, brand, and description without page reloads (`assets/js/main.js`).
   - Category filtering pills with real-time product count.
3. **Direct WhatsApp Quotation Engine**:
   - Every product card has an instant WhatsApp enquiry button pre-filling the product name, ID, and bulk pricing request.
   - Interactive wholesale requirement builder form generating formatted B2B purchase drafts.
4. **Downloadable 89-Page PDF Catalogue**:
   - Complete 11 MB PDF catalogue bundled at `assets/docs/Khushi-Enterprises-Wholesale-Catalogue.pdf`.
5. **GoDaddy cPanel Ready Backend**:
   - PHP PDO database connector (`config/db.php`) with **automatic JSON fallback**. The website functions 100% out-of-the-box on standard GoDaddy shared hosting even before a MySQL database is created.
   - `database.sql` provided for one-click phpMyAdmin table creation.
   - `admin/index.php` password-protected portal (`khushi2026`) for reviewing submitted enquiries, opening direct WhatsApp replies, and exporting to CSV.
6. **Apache Optimization**:
   - `.htaccess` configured for Gzip compression, browser caching, and security headers.
