# 🧲 Lead Magnet Collector v3 — by Jinwo0x1400

🚀 The most advanced lead collection tool by Jinwoo!

---

## 🧠 What’s New in v3

- ✅ Google Sheets Integration (store leads to cloud)
- ✅ Realtime Telegram Notification
- ✅ Realtime Email Notification
- ✅ Still saves locally to `leads.csv`
- ✅ GUI viewer with password `jinwoo1400`

---

## 🔧 Setup Required

### 1. Google Sheets
- Create a Google Sheet with columns: Time, IP, Name, Email
- Go to [script.google.com](https://script.google.com)
- Paste the script from `googlesheet.gs` into the editor
- Deploy as web app with "Anyone" access
- Copy your Web App URL and paste into `submit.php`

### 2. Telegram
- Create a Bot via @BotFather and get token
- Add your chat ID from @userinfobot
- Paste token & chat_id into `submit.php`

### 3. Email Notification
- Set your email in `submit.php` (use PHP `mail()` function)

---

📂 Files:

- `form.html` – lead form
- `submit.php` – collects + sends to Google/Telegram/Email
- `viewer.php` – protected GUI to view local CSV
- `leads.csv` – local storage
- `googlesheet.gs` – Google Apps Script for Sheets

---

© 2025 Jinwo0x1400 — Jinwoo Tools™
