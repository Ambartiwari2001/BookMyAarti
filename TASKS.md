# BookMyAarti - Project Task & Implementation Roadmap

> **Platform Overview:** A full-stack Laravel application featuring a devotee-facing portal to discover and book Ganga Aarti / spiritual rituals, paired with an administrative control panel for managing ghats, aarti schedules, devotee quotas, passes, and check-ins.  
> **Tech Stack:** Laravel (PHP 8.3) • Blade Templates • Tailwind CSS v4 • SQLite / MySQL • Pest Testing

---

## Architecture & Module Summary

| Section | Role / Purpose | Key Highlights |
| :--- | :--- | :--- |
| **Devotee Portal (User Website)** | Public visitors & devotees | Ghat discovery, slot booking, sankalp details, pass generation, booking history |
| **Admin Control Panel** | Temple / Ghat Management & Operations | Live dashboard, slot management, capacity controls, ticket verification, devotee registers |
| **Core Engine** | Shared backend | Role-based authentication, quota tracking, QR pass generator, notifications |

---

## Phase 1: Database Architecture, Models & Authentication

- [x] **1.1 Setup Roles & User Types**
  - [x] Add `role` column to `users` table (`'devotee'`, `'admin'`, `'ghat_coordinator'`).
  - [x] Configure authentication guards and role-check middleware (`EnsureUserIsAdmin`).
  - [x] Implement Devotee & Admin login / registration Blade views with convenient 1-click test login.

- [x] **1.2 Create Database Schema & Migrations**
  - [x] `ghats`: Name (Dashashwamedh Ghat, Har Ki Pauri, Triveni Ghat, Assi Ghat), City, State, Description, Image, Rules, Reporting Instructions.
  - [x] `aartis`: Title (Maha Ganga Aarti, Morning Subah-e-Banaras, etc.), Ghat ID, Aarti Type, Duration, Description, Banner Image.
  - [x] `aarti_slots`: Aarti ID, Slot Date, Start Time, End Time, Reporting Time, Total Capacity, Available Seats, Price (Free or VIP Seating Fee), Status.
  - [x] `bookings`: Unique Reference (`BMA-2026-XXXX`), User ID, Aarti Slot ID, Devotee Count, Total Amount, Payment Status, Booking Status, QR Token.
  - [x] `devotee_details`: Booking ID, Name, Age, Gender, Gotra, Sankalp Purpose.
  - [x] `add_ons`: Prasad Boxes, Floating Diyas, Ganga Jal Kalash, Boat Viewing Seats.
  - [x] `booking_add_ons`: Pivot linking bookings with selected offerings and quantities.

- [x] **1.3 Eloquent Models, Relationships & Seeders**
  - [x] Models: `Ghat`, `Aarti`, `AartiSlot`, `Booking`, `DevoteeDetail`, `AddOn`, `BookingAddOn`.
  - [x] Relationships and atomic transaction seat decrement logic.
  - [x] Seeders: Preloaded ghats (Varanasi, Haridwar, Rishikesh) and daily slots for the next 14 days.

---

## Phase 2: User Website (Devotee Portal) - Blade Views

- [x] **2.1 Devotee Layout & Theme**
  - [x] Shared layout with spiritual theme (sacred saffron, temple gold, clean typography).
  - [x] Responsive navigation bar: Home, Book Aarti, Sacred Ghats, My Passes.
  - [x] Mobile-optimized controls.
  - [x] Divine footer with ghat timings, emergency contacts, FAQs, and spiritual guidelines.

- [x] **2.2 Home / Landing Page (`/`)**
  - [x] Hero section with Aarti imagery, quick booking search (City, Date, Devotee count).
  - [x] "Featured Aartis" showcase with live timing badges.
  - [x] "Explore Holy Ghats" interactive grid (Varanasi, Haridwar, Rishikesh).
  - [x] Today's live Aarti slot ticker with remaining seat counters.
  - [x] How Devotee Booking Works (3 visual steps).

- [x] **2.3 Aarti Listing & Search Page (`/aartis`)**
  - [x] Filters by City / Location, Ritual Type (Morning / Evening).
  - [x] Ceremony card grid displaying timings, starting price, and slot links.

- [x] **2.4 Aarti Details & Slot Selection (`/aartis/{slug}`)**
  - [x] Ceremony background, spiritual significance & Mahima, ritual sequence (Vidhi).
  - [x] Reporting gate instructions and dress code guidelines.
  - [x] Slot calendar grouped by date with real-time seat availability indicator.

- [x] **2.5 Devotee Booking Flow (`/book/{slot}`)**
  - [x] Tier Selection (General Free Darshan vs VIP Dais Platform).
  - [x] Primary contact details (Name, Phone, Email, City).
  - [x] Individual Devotee Details (Name, Age, Gender, Gotra, Sankalp blessing wish).
  - [x] Sanctified Offerings (Prasad hampers, floating deepams, copper kalash, boat seats).
  - [x] Live dynamic price calculator in JavaScript.

- [x] **2.6 Digital E-Pass & Gate Ticket (`/booking/pass/{booking_number}`)**
  - [x] Authentic temple pass styling with simulated QR matrix and reference token.
  - [x] Gate reporting deadline and entry instructions.
  - [x] Full list of registered devotees, gotras, and sankalp intentions.
  - [x] Clean print stylesheet (`window.print()`).

- [x] **2.7 Devotee Dashboard / "My Passes" (`/my-bookings`)**
  - [x] Search pass by Mobile Phone number or Booking Reference.
  - [x] Active and past booking passes list.
  - [x] Self-service booking cancellation with automatic slot quota restoration.

---

## Phase 3: Admin Control Panel - Blade Views & Operations

- [x] **3.1 Admin Authentication & Dashboard (`/admin`)**
  - [x] Role protection middleware (`EnsureUserIsAdmin`).
  - [x] Key performance metrics: Today's Bookings, Devotees Today, Total Seva Donations, Sanctuaries count.
  - [x] Today's Aarti slots capacity progress bars.
  - [x] Recent Devotee Bookings table with quick actions.

- [x] **3.2 Holy Ghats & Locations Management (`/admin/ghats`)**
  - [x] List, Create, Edit, and Delete Ghats.
  - [x] Manage address, river, helpline, reporting instructions and guidelines.

- [x] **3.3 Aarti & Rituals Management (`/admin/aartis`)**
  - [x] CRUD for Aarti listings (Title, Description, Ghat association, Ritual vidhi, Duration).
  - [x] Pricing configuration and featured toggle.

- [x] **3.4 Slots & Capacity Scheduler (`/admin/slots`)**
  - [x] Date and ceremony filterable slot calendar.
  - [x] **1-Click Batch Slot Generator:** Automatically generate 7, 14, 30, or 60 days of daily slots in advance!
  - [x] Single slot creator & capacity / status editor.

- [x] **3.5 Bookings Management & Guest Register (`/admin/bookings`)**
  - [x] Filterable table by devotee name, phone, booking number, date, ghat, and status.
  - [x] Detailed booking view with attendee list, Gotra, Sankalp prayers, and payment breakdown.
  - [x] One-click Gate Check-In & cancellation actions.
  - [x] **Daily Devotee Sankalp Register (`/admin/bookings/print/register`):** Authentic printable ledger for Vedic Priests to recite devotee names and Gotra during evening Pushpanjali!

- [x] **3.6 Gate Pass Scanner & Check-In (`/admin/check-in`)**
  - [x] Rapid barcode / QR hash scanner and search input.
  - [x] Instant validity verification screen with devotee counts and offerings checklist.
  - [x] One-click "Confirm Gate Entry" to prevent duplicate admissions.

- [x] **3.7 Add-ons & Prasad Management (`/admin/add-ons`)**
  - [x] Full CRUD for offerings (Prasad boxes, floating deepams, boat seats).

---

## Phase 4: Styling, UI/UX & Verification

- [x] Spiritual color palette (Deep saffron, marigold gold, sacred temple maroon, slate darks).
- [x] Vite asset compilation (`npm run build`).
- [x] Full Pest test suite passing (all 9 feature tests).
- [x] Laravel Pint code formatting verified.
