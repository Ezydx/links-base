# LinksBase - Personal Bookmarks & Web Tools Hub

A modern, hierarchical card-based bookmark management system written in modular PHP, designed to replace crowded browser bookmark bars with organized tags, sub-categories, and interactive cards.

---

## 🚀 Quick Start & Aliases

### Option 1: Double-click `serve.bat` (Recommended)
Just double-click **[`serve.bat`](file:///d:/collections/links-base/serve.bat)**!
* Automatically checks the server health via HTTP.
* Launches your browser to `http://localhost:8000` in a new tab the moment the server is verified live.

### Option 2: Run via `npm start`
Since you have Node.js installed, open terminal in this folder and type:
```powershell
npm start
# or: node serve.js
```

### Option 3: PowerShell Global Alias
Want to type `links` anywhere in PowerShell to start the app?
Add this function to your PowerShell profile:
```powershell
# Run this once in PowerShell:
Add-Content $PROFILE "function links { Set-Location 'D:\collections\links-base'; node serve.js }"
```
Now, whenever you type `links` in any PowerShell window, the server boots up and pops open in your browser automatically!

---

## 🗂️ How the Card & Tag Hierarchy Works

1. **Main Page (`index.php`)**:
   - Shows **Major Category Cards** (e.g. *Development*, *Design*, *Media*, *Utilities*, *Web Hosting*, *Social*).
   - Each card displays total links count, sub-category counts, and preview chips.
   - Clicking a major category card opens that category's view.

2. **Major Category Page (`page/major.php?tag=...`)**:
   - Shows **Minor Sub-Category Cards** (e.g. for *Development*: *Bootcamp & Fullstack*, *Reference & Docs*, *IDE & Platforms*, *Android & Mobile*, *Repositories*).
   - Clicking a minor card opens that specific sub-tag's links view.
   - Also includes an "All Links in Category" overview section at the bottom.

3. **Minor Sub-Category Page (`page/minor.php?major=...&minor=...`)**:
   - Displays **Rich Link Cards**.
   - Each link card contains:
     - High-resolution site favicon / icon / SVG.
     - Title & clean domain badge (e.g. `github.com`, `figma.com`, `Local File`).
     - Notes / description (e.g. *"website for Android developers , build and docs"*).
     - Category and sub-category badges.
     - Direct **"Open Site"** button + **clicking anywhere on the card opens the link in a new tab** (`target="_blank"`).
     - **"Copy Link"** button with instant toast confirmation.
     - **"Delete"** button to remove the bookmark.

4. **Topbar & Hero Features**:
   - **Live Clock (`Date now: ...`)**: Upgraded, elegant live clock showing current date, time, and seconds (preserving your original clock).
   - **Global Search**: Type any keyword in the search bar to filter links across titles, URLs, descriptions, and tags.
   - **`+ Add Link` Button & Modal**: Accessible on every page. Lets you enter URL, Title, Major Tag, Minor Tag, and Notes.

---

## 💾 Database Options: SQLite vs. PostgreSQL

The system uses **PHP PDO** so you can seamlessly toggle between SQLite and PostgreSQL in **`config.php`**:

### 1. SQLite (Active by default)
- **Zero configuration needed**: Works immediately out-of-the-box without needing any external database server or credentials.
- Stored safely in `data/links.db`.
- All your 35 original bookmarks have already been seeded and categorized into `data/links.db`!

### 2. PostgreSQL (Local Postgres 18)
To switch to PostgreSQL:
1. Open `config.php`.
2. Change:
   ```php
   define('DB_DRIVER', 'pgsql');
   ```
3. Set your PostgreSQL credentials:
   ```php
   define('PG_HOST', 'localhost');
   define('PG_PORT', '5432');
   define('PG_DBNAME', 'links_base');
   define('PG_USER', 'postgres');
   define('PG_PASS', 'your_password');
   ```
4. Enable `extension=pdo_pgsql` and `extension=pgsql` in `C:\xampp\php\php.ini` (remove the leading `;` semicolon on lines 947 & 933).
5. Create the database in Postgres (`CREATE DATABASE links_base;`). The app will automatically initialize the tables on first run, or you can import `schema.sql`.

---

## 📁 Project Structure

```text
links-base/
├── config.php            # Database PDO settings (SQLite & PostgreSQL)
├── schema.sql            # SQL schema definitions for reference
├── seed.php              # Seeder with all 35 bookmarks from your original HTML
├── index.php             # Main dashboard (Major category cards)
├── serve.bat             # Quick 1-click launcher for Windows
├── serve.ps1             # PowerShell launcher script
├── original_index.html   # Backup copy of your original index.html file
├── data/
│   └── links.db          # Active SQLite database file
├── includes/
│   ├── header.php        # Sticky topbar, live clock, search, and Add Link modal
│   ├── footer.php        # App footer and toast container
│   └── functions.php     # Helper queries, SVG icons, and favicon resolvers
├── page/
│   ├── major.php         # Major category view (Minor tag cards)
│   ├── minor.php         # Minor sub-tag view (Interactive link cards)
│   └── search.php        # Global search results view
├── api/
│   └── save_link.php     # Handles link addition, deletion, and tag listings
├── style/
│   └── style.css         # Modern dark glassmorphic styling, responsive layout
└── script/
    └── app.js            # Live clock ticker, modal controls, card click handlers
```
