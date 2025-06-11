# 🧲 Lead Magnet Collector v11 — by Jinwo0x1400

🚨 Real-time engagement + predictive lead scoring — now pluggable.

---

## 🧠 What's New in V11

- 🔔 Real-time notifications to **Email**, **Telegram**, and **WhatsApp**
- 🧠 AI-style **Lead Scoring System** (0–100)
- 🔌 Plugin system for custom logic (via `plugins/`)
- 💾 SQLite database
- 🔐 Role-based login

---

## 📬 Notifications

- 📧 Email: sent via mail()
- 📲 Telegram: add bot token + chat ID
- 📞 WhatsApp: use CallMeBot.org (free)

---

## 🧮 Lead Scoring (Example)

| Rule | Score |
|------|-------|
| email has “vip” or domain | +30 |
| IP is from known country  | +20 |
| email has “test”, “temp”  | -50 |
| default score             | 50  |

---

## 📂 Files

- `form.html`
- `submit.php`
- `panel.php`
- `score.php` — scoring logic
- `plugins/` — drop-in PHP functions

© 2025 Jinwo0x1400 — Auto Intelligence CRM™
