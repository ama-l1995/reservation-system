# Service Reservation System

Laravel 11 platform for booking services (consultations, coaching, etc.). Includes:

- Admin dashboard with Livewire
- RESTful API secured by Sanctum
- Email notifications
- Bootstrap 5 UI

---

## 🛠️ Setup Instructions

```bash
git clone https://github.com/ama-l1995/reservation-system.git
cd reservation-system

composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run dev
php artisan serve

Login as admin:

Register via /register

Set is_admin = 1 manually in users table

🧩 Tech Stack
Laravel 11

Livewire 3

Sanctum

MySQL

Bootstrap 5

Mailtrap

⚙️ Features
Service management (create, update, delete)

Reservation with double-booking prevention

Admin dashboard

Email alerts on confirm/cancel

📄 API Endpoints
Endpoint	Method	Description
/api/services	GET	List all services
/api/reservations	GET	List user reservations
/api/reservations	POST	Create a reservation

Authenticated via Sanctum

📌 Notes
Admin dashboard: /admin/dashboard

Uses repository & service patterns for clean code



