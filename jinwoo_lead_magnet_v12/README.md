# 🧲 Lead Magnet Collector v12 — by Jinwo0x1400

🌐 The final evolution. All-in-one CRM lead manager.

---

## 🔥 What's New in V12

- 📱 **Mobile-optimized UI** with responsive Bootstrap layout
- 🧠 **Multi-campaign system** (each form can be assigned to a campaign)
- 🌐 **Webhook Builder** (Zapier, Make.com, Pabbly, custom endpoint)
- 📁 All leads stored in SQLite with campaign linkage
- 🧩 Plugin & scoring support retained

---

## 🗂 Campaign Mode

Each form submits to a unique `campaign_id`, e.g.:
```html
<input type="hidden" name="campaign" value="casino2025">
```

---

## ⚙️ Webhook Setup

1. Go to `webhooks.json`
2. Add your campaign and destination URL(s)
```json
{
  "casino2025": ["https://hooks.zapier.com/..."],
  "emailpush": ["https://custom-crm.com/lead"]
}
```

---

## 🔐 Access Login

- Admin: `admin` / `jinwoo1400`
- Viewer: `viewer` / `viewonly1400`

---

✅ Best for performance marketers, affiliate CRM, and team lead tracking.

© 2025 Jinwo0x1400 — Fullstack Funnel Engine™
