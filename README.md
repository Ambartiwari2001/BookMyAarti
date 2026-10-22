# 🙏 BookMyAarti

> **Divine Aarti Darshan & Digital E-Pass Management Portal**  
> A full-stack spiritual ritual and Aarti booking platform connecting devotees with sacred ghats across India (Varanasi, Haridwar, Rishikesh).

---

## 📌 Project Overview

**BookMyAarti** streamlines the pilgrimage experience by enabling devotees to explore sacred ghats, reserve General or VIP Aarti slots, submit Gotra and Sankalp prayer requests, order sanctified offerings (Prasad hampers, holy Gangajal, floating diyas), and obtain instant digital QR E-Passes.

It also provides an administrative control panel for temple trusts and ghat coordinators to manage ritual schedules, control capacity, verify passes via gate check-in scanner, and generate daily Sankalp registers for Vedic priests.

---

## ✨ Key Features

### 🌸 Devotee Portal

- **Sacred Ghats & Rituals:** Explore holy ghats (Dashashwamedh Ghat, Har Ki Pauri, Triveni Ghat, Assi Ghat) with schedules, reporting gates, and guidelines.
- **Real-Time Slot Booking:** Instant seat availability indicator for morning and evening ceremonies.
- **Sankalp & Devotee Registration:** Add devotee details, Gotra, and custom prayer intentions.
- **Sanctified Offerings (Add-ons):** Select Prasad boxes, sealed copper Gangajal kalash, eco-friendly floating diyas, and boat viewing seats.
- **Digital QR E-Pass:** Instant printable gate ticket featuring an authentic simulated QR matrix and reference token.
- **My Passes & Self-Service:** Search bookings by phone number or reference ID, view active passes, and cancel bookings with automated seat quota restoration.

### ⚙️ Admin Control Panel (`/admin`)

- **Operations Dashboard:** Live tracking of daily bookings, devotee attendance, capacity utilization bars, and seva donations.
- **Ghats & Ceremonies Management:** Full CRUD operations for ghat locations, ritual descriptions, and timings.
- **Batch Slot Generator:** Automatically create recurring daily slots for 7, 14, 30, or 60 days in one click.
- **Gate Check-In & Scanner:** Quick token lookup and QR scanner to validate tickets and record gate entry.
- **Priest Devotee Register:** Printable daily ledger formatted for Vedic priests to recite devotee names and Gotras during evening prayers.

---

## 🛠️ Tech Stack

- **Backend:** Laravel 12 (PHP 8.3)
- **Frontend:** Blade Templates & Tailwind CSS v4
- **Database:** SQLite (default) / MySQL
- **Testing:** Pest PHP
- **Bundler:** Vite

---

## 🚀 Quick Start Guide

### 1. Clone & Install Dependencies

```bash
composer install
npm install
```

### 2. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database Migration & Seeding

```bash
php artisan migrate --seed
```

### 4. Build Assets & Start Application

```bash
npm run build
php artisan serve
```

_Alternatively, run concurrently:_

```bash
composer run dev
```

Access the application at: `http://localhost:8000`

---

## 🔑 Demo & Test Credentials

| Role        | Email                   | Password   | Access URL |
| :---------- | :---------------------- | :--------- | :--------- |
| **Admin**   | `admin@bookmyaarti.com` | `password` | `/admin`   |
| **Devotee** | `devotee@example.com`   | `password` | `/login`   |

_(A 1-click test login shortcut is also provided directly on the login page)._

---

## 🧪 Testing

Run automated feature and unit tests with Pest:

```bash
php artisan test
```

---

## 📄 License

This project is open-source software licensed under the [MIT License](LICENSE).
