Service Reservation System
Overview
A Laravel 11-based platform for browsing and reserving services such as consultations or coaching sessions. Features a custom admin dashboard powered by Livewire for dynamic management of services and reservations, robust RESTful APIs with Sanctum authentication, and email notifications for reservation updates. The system ensures scalability, prevents double bookings, and provides a professional user experience with Bootstrap 5.

Setup Instructions
Clone the Repository:
bash

Copy
git clone https://github.com/your-username/service-reservation-system.git
cd service-reservation-system
Install Dependencies:
bash

Copy
composer install
npm install
Configure Environment:
Copy .env.example to .env:
bash

Copy
cp .env.example .env
Update .env with your database credentials (reservation_db) and Mailtrap settings for email notifications.
Generate application key:
bash

Copy
php artisan key:generate
Run Migrations:
bash

Copy
php artisan migrate
Install Livewire:
bash

Copy
composer require livewire/livewire
Compile Assets:
bash

Copy
npm run dev
Run the Application:
bash

Copy
php artisan serve
Access the application at http://localhost:8000.
Admin dashboard at http://localhost:8000/admin/dashboard.
Create Admin User:
Register a user via /register.
Manually set is_admin to 1 in the users table for admin access.
Tool Choices
Laravel 11: Modern PHP framework for robust backend development.
Livewire 3: Enables dynamic, reactive admin dashboard without complex JavaScript.
Sanctum: Secure authentication for web and API endpoints.
MySQL: Relational database for efficient data management.
Bootstrap 5: Responsive and professional UI with modern styling.
Mailtrap: Testing email notifications for reservation confirmations and cancellations.
Design Decisions
Repository Pattern: Separates database operations (via ServiceRepository, ReservationRepository) for maintainability and testability.
Service Pattern: Encapsulates business logic (ServiceService, ReservationService) for cleaner controllers.
Livewire Dashboard: Custom admin interface for managing services and reservations, replacing Filament/Backpack for Laravel 11 compatibility.
Double Booking Prevention: Validates reservation time slots to avoid conflicts.
Email Notifications: Sends confirmation and cancellation emails using Laravel Mail.
RESTful APIs: Provides secure endpoints for services and reservations with Sanctum authentication.
Known Limitations
Real-time Updates: Lacks WebSocket-based notifications (e.g., via Pusher) for instant reservation updates.
Frontend Interactivity: Relies on Blade/Livewire; Vue.js could enhance dynamic features but was omitted for simplicity.
Calendar View: No visual calendar for selecting reservation slots, which could improve UX.
Business Requirements Understanding
The system streamlines service reservations for users by offering an intuitive platform to browse and book services like consultations, coaching, or repairs. It supports businesses by providing admins with a powerful dashboard to manage services, monitor reservations, and view statistics (e.g., total reservations, popular services). The platform ensures reliability through double-booking prevention and email notifications, enhancing user trust and operational efficiency. Scalability is achieved via clean code architecture and APIs for future integrations.

Feature Suggestion
Suggested Feature: Interactive calendar view for reservation time slots.
Reason: A calendar interface allows users to visually select available slots, reducing booking errors and improving UX. It could integrate with FullCalendar.js and Livewire for real-time updates, making the booking process more engaging and efficient.

System Flow
mermaid

Copy
graph TD
    A[User] -->|Register/Login| B[Auth System]
    B --> C[Browse Services]
    C -->|Select Service| D[Reserve Service]
    D --> E[Confirmation Email]
    A --> F[View Reservations]
    F -->|Cancel| G[Cancellation Email]
    H[Admin] -->|Login| I[Admin Dashboard]
    I --> J[Manage Services]
    I --> K[Monitor Reservations]
    K -->|Confirm/Cancel| L[Update Status]
    M[API Client] -->|Authenticate| N[Sanctum]
    N --> O[Access API Endpoints]
Testing Video
A walkthrough video (walkthrough.mp4) is included in the repository, demonstrating the system's functionality, including user registration, service reservation, admin dashboard management, and API usage. The video explains the code structure and design decisions.

Code Structure
text

Copy
service-reservation-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── ServiceController.php
│   │   │   ├── ReservationController.php
│   │   │   ├── Api/
│   │   │   │   ├── ServiceController.php
│   │   │   │   ├── ReservationController.php
│   ├── Livewire/
│   │   ├── AdminDashboard.php
│   ├── Mail/
│   │   ├── ReservationConfirmed.php
│   │   ├── ReservationCancelled.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Service.php
│   │   ├── Reservation.php
│   ├── Repositories/
│   │   ├── ServiceRepository.php
│   │   ├── ReservationRepository.php
│   ├── Services/
│   │   ├── ServiceService.php
│   │   ├── ReservationService.php
├── resources/
│   ├── css/
│   │   ├── app.css
│   ├── js/
│   │   ├── app.js
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   ├── auth/
│   │   │   ├── login.blade.php
│   │   │   ├── register.blade.php
│   │   ├── services/
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   ├── edit.blade.php
│   │   ├── reservations/
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   ├── emails/
│   │   │   ├── reservation_confirmed.blade.php
│   │   │   ├── reservation_cancelled.blade.php
│   │   ├── livewire/
│   │   │   ├── admin-dashboard.blade.php
├── routes/
│   ├── web.php
│   ├── api.php
├── README.md
Additional Notes
Double Booking Prevention: Implemented in ReservationService by checking time slot availability before creating/updating reservations.
Admin Access: Secured with admin middleware; only users with is_admin = 1 can access the dashboard.
API Documentation: Endpoints are available at /api/services and /api/reservations, requiring Sanctum token authentication.
Styling: Bootstrap 5 with custom CSS for hover effects and responsive design.
This system is designed to impress with its clean architecture, dynamic admin interface, and comprehensive feature set, making it a robust solution for service-based businesses.
