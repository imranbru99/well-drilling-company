# Stonebore Well Co. — Laravel 13 + Filament 3 Website, ERP & AI

Production-ready SME platform for a Tulsa / Northeast Oklahoma **water well drilling company**: public marketing site, Filament admin ERP, knowledge base, and AI assistants for chat, content, automation ideas, and troubleshooting. Brand: **Stonebore Well Co.**

## ✨ Features
- 🏠 Public marketing site with hero, services, about, dashboard preview, and contact form
- 💧 Service detail pages for residential, agricultural, commercial wells, pumps, hydrofracturing, and water testing
- 📰 Blog / knowledge posts seeded with well-drilling guidance
- 📚 Knowledge base: common issues, guides, admin manual, troubleshooting
- 💬 Floating WhatsApp button + public AI chatbot (FAQ demo or live API)
- 🗂️ Filament ERP at `/admin` — customers, jobs, inventory, invoices, payments, appointments
- 👥 Roles: Admin, Manager, Staff
- 📊 Reports dashboard with stats + jobs chart widgets
- ⚙️ Company settings page
- 🤖 Admin AI: content generator, automation suggestions, troubleshooting assistant
- 🌱 Realistic demo seeders for Northeast Oklahoma well operations

## 🛠️ Tech Stack
- Laravel 13
- Filament 3
- Tailwind CSS + Vite + Livewire + Alpine.js
- MySQL or SQLite (demo default)
- OpenAI PHP Laravel SDK + Gemini HTTP fallback (optional keys) with FAQ demo mode
- Spatie Laravel Permission

## 🚀 Installation
```bash
git clone https://github.com/imranbru99/well-drilling-company.git
cd well-drilling-company
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
npm install
npm run build
php artisan serve
```

Admin panel: `http://localhost:8000/admin`  
Login: `admin@example.com` / `password`

Configure `OPENAI_API_KEY` or `GEMINI_API_KEY` in `.env` for live AI; otherwise demo FAQ responses are used.

For MySQL, set `DB_CONNECTION=mysql` and related credentials in `.env`, then migrate again.

## 🖼️ Screenshots / Visual Dashboard
![Northeast Oklahoma landscape for groundwater](https://images.unsplash.com/photo-1470070371334-43b456c8c8ba?auto=format&fit=crop&w=1200&q=80)

![Rural residential property needing a domestic well](https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=1200&q=80)

![Agricultural land for livestock water wells](https://images.unsplash.com/photo-1500595046743-cd271d694d30?auto=format&fit=crop&w=1200&q=80)

![Pump and electrical service for well systems](https://images.unsplash.com/photo-1621905252507-b35492cc74b4?auto=format&fit=crop&w=1200&q=80)

## 🌐 Live Demo
Placeholder — deploy to your host and share the public URL + `/admin` demo credentials.

## 🔍 SEO-Optimized Repo Description Suggestion
`Stonebore Well Co. — Laravel 13 + Filament 3 website, ERP, and AI chatbot for US water well drilling SMEs (wells, pumps, hydrofracturing, KB).`

---

## 🤝 Let's Connect & Collaborate
I am open to Senior Remote Full-Stack Roles, AI Platform Architecture Contracts, and Enterprise Technical Advisory.
Timezone: UTC+6 (Dhaka / Rangpur, Bangladesh) — Flexible overlap with US, UK, and European business hours.
Delivery Mode: Async-ready, Slack, Discord, Jira, GitHub, and production-first accountability.

| Channel | Address / Handle | Quick Action |
|---------|------------------|--------------|
| 🌐 Primary Portfolio | imrandev.bd | Visit Site ↗ |
| 📦 Packagist Packages | packagist.org/packages/imrandevbd/ | View Packages ↗ |
| 💼 LinkedIn Profile | linkedin.com/in/imranbru99 | Connect ↗ |
| 🐙 GitHub Profile | github.com/imranbru99 | Follow ↗ |
| 💬 WhatsApp Direct | +880 1576-918420 | Chat Now ↗ |
| 📧 Direct Email | me@imrandev.bd | Send Email ↗ |
| 🐦 X (Twitter) | @imrandev_bd | Follow ↗ |
| 📺 YouTube Tech | @ImranDevBD | Subscribe ↗ |
