# Instructions for Antigravity (Office / Remote Agent)

> **Hello Antigravity Agent!** If you are reading this at the user's office workstation, this file instructs you on how to understand, maintain, and expand this codebase.

---

## 1. Project Overview & Quick Orientation
- **Project**: Production B2B Wholesale Website for **Khushi Enterprises**, Pune, Maharashtra.
- **Client**: Waheed Chitapure / Khushi Enterprises.
- **Location**: `Inam Nagar, Betal Nagar, Kondhwa, Pune, Maharashtra 411048`.
- **Contacts**: `+91 80506 53180` and `+91 81496 65755`.
- **Target Audience**: Hardware and sanitary shop owners across Pune and Maharashtra.

---

## 2. Core Architectural Principles
1. **Zero External Heavy Frameworks**:
   - The site uses semantic HTML5, pure modular CSS3 (`assets/css/style.css`), and vanilla JavaScript (`assets/js/main.js`). Do not add heavy node/npm dependencies (React, Vue, Webpack, etc.) unless explicitly instructed by the user, because this site is deployed directly to **GoDaddy cPanel Shared Hosting (`public_html`)**.
2. **GoDaddy cPanel Compatibility**:
   - The backend runs on PHP PDO (`config/db.php`, `api/enquiry.php`).
   - Notice the **automatic JSON fallback**: If MySQL is offline or unconfigured, enquiries are automatically logged to `api/enquiries.json` and products are read from `api/products.json`. Never break this fallback.
3. **Mobile-First Priority**:
   - More than 90% of buyers browse from mobile phones.
   - Always preserve the **Mobile Sticky Action Bar** (`.mobile-sticky-bar` in `assets/css/style.css`):
     `[ 🟢 WhatsApp ] [ 📞 Call Now ] [ 📍 Directions ] [ 📥 PDF List ]`
4. **Brand Color Palette**:
   - Primary: Deep Navy Blue (`#0a1d37`, `#071527`)
   - Accent: Warm Rich Gold (`#c69234`, `#dcb059`, `#faf6ee`)
   - Green for WhatsApp: `#25d366`
   - Backgrounds: Clean whites and soft slate (`#ffffff`, `#f8fafc`, `#f1f5f9`).
5. **Language & Copywriting Style**:
   - Clean professional English paired with impactful Roman Hindi taglines (e.g., *"Apki Dukaan Ka Reliable Wholesale Partner"*, *"Quality Maal. Best Rates. Reliable Supply."*).
   - **Crucial**: Do NOT use Unicode Devanagari script. All Hindi touches must remain in Roman/Latin script.

---

## 3. Product Catalogue Management
- All 89 products are mapped in two locations:
  1. `assets/js/products-data.js` (for instantaneous client-side searching and filtering).
  2. `api/products.json` (for backend REST API responses).
- Real product images are in `assets/images/products/product_01.jpg` through `product_89.jpg`.
- To add a new product:
  - Add image to `assets/images/products/`.
  - Add object entry to `assets/js/products-data.js` and `api/products.json`.
  - Categories: `bath-fittings`, `waste-drain`, `pipes-hoses`, `drain-cleaners`, `cistern-toilet`, `valves-hardware`, `hardware`, `electrical-conduit`.

---

## 4. Key References
- Complete project context: [PROJECT_CONTEXT.md](file:///C:/Users/Admin/.gemini/antigravity/scratch/khushi-enterprises/PROJECT_CONTEXT.md)
- Complete conversation log: [CONVERSATION_HISTORY.md](file:///C:/Users/Admin/.gemini/antigravity/scratch/khushi-enterprises/CONVERSATION_HISTORY.md)
- GoDaddy deployment instructions: [GODADDY_DEPLOYMENT_GUIDE.md](file:///C:/Users/Admin/.gemini/antigravity/scratch/khushi-enterprises/GODADDY_DEPLOYMENT_GUIDE.md)
- Master generation prompt: [PROMPT_MASTER_REFERENCE.md](file:///C:/Users/Admin/.gemini/antigravity/scratch/khushi-enterprises/PROMPT_MASTER_REFERENCE.md)
