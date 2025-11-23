# ParkSmart - Smart Parking Management System

A modern parking reservation system built with Laravel. Users can book parking slots, track time in real-time, and pay on exit.

---

## 🚀 Features

### User Features
- ✅ User registration and authentication
- ✅ Browse 100 parking slots organized by floors (Ground Floor to 4th Floor)
- ✅ Real-time slot availability
- ✅ Book parking slots instantly
- ✅ Real-time timer and cost calculator
- ✅ Pay-on-exit system
- ✅ View booking history
- ✅ Beautiful responsive UI with purple gradient theme

### Admin Features (To be implemented)
- 🔧 Admin dashboard
- 🔧 Manage parking slots
- 🔧 View all reservations
- 🔧 Generate reports

---

## 📋 Prerequisites

Before you begin, make sure you have installed:
- PHP 8.1 or higher
- Composer
- SQLite (comes with PHP)
- Node.js & NPM (optional, for asset compilation)

---

## 🛠️ Installation & Setup

### 1. Clone the Repository
```bash
git clone <your-repo-url>
cd parksmart
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Environment Setup

Copy the example environment file:
```bash
cp .env.example .env
```

Generate application key:
```bash
php artisan key:generate
```

### 4. Database Setup

The project uses SQLite. The database file should already exist at `database/database.sqlite`.

If it doesn't exist, create it:
```bash
touch database/database.sqlite
```

Run migrations:
```bash
php artisan migrate
```

### 5. Seed Parking Slots

Open Laravel Tinker:
```bash
php artisan tinker
```

Create 100 parking slots (5 floors, 20 slots each):
```php
$floors = [
    ['name' => 'Ground Floor', 'prefix' => 'GF', 'price' => 200],
    ['name' => '1st Floor', 'prefix' => '1F', 'price' => 150],
    ['name' => '2nd Floor', 'prefix' => '2F', 'price' => 120],
    ['name' => '3rd Floor', 'prefix' => '3F', 'price' => 100],
    ['name' => '4th Floor', 'prefix' => '4F', 'price' => 80],
];

foreach ($floors as $floor) {
    for ($i = 1; $i <= 20; $i++) {
        \App\Models\ParkingSlot::create([
            'slotNumber' => $floor['prefix'] . '-' . str_pad($i, 2, '0', STR_PAD_LEFT),
            'location' => $floor['name'],
            'status' => 'Available',
            'pricePerHour' => $floor['price']
        ]);
    }
}

echo "Created 100 parking slots!";
```

Verify slots were created:
```php
\App\Models\ParkingSlot::count();  // Should return 100
```

Type `exit` to leave Tinker.

### 6. Create Admin Account

Open Tinker again:
```bash
php artisan tinker
```

Create an admin user:
```php
\DB::table('User')->insert([
    'fullName' => 'Admin User',
    'email' => 'admin@parksmart.com',
    'password' => bcrypt('admin123'),
    'phoneNumber' => '0712345678',
    'role' => 'admin',
    'dateRegistered' => now()
]);
```

Verify admin was created:
```php
\DB::table('User')->where('email', 'admin@parksmart.com')->first();
```

Type `exit` to leave Tinker.

### 7. Start the Application
```bash
php artisan serve
```

The application will be available at: `http://127.0.0.1:8000`

---

## 🎯 Usage

### For Regular Users:

1. **Visit the landing page:** `http://127.0.0.1:8000`
2. **Register:** Click "Get Started (Register)"
3. **Login:** Use your credentials
4. **View Slots:** Click "View Slots" from the dashboard
5. **Book a Slot:** Choose a slot and click "Book Now"
6. **Track Your Booking:** Go to "My Reservations" to see real-time timer and cost
7. **End & Pay:** Click "End Reservation & Pay" when done parking

### For Admin:

1. **Admin Login:** `http://127.0.0.1:8000/admin/login`
2. **Credentials:**
   - Email: `admin@parksmart.com`
   - Password: `admin123`
3. **Admin Dashboard:** (To be implemented by team member)

---

## 📁 Project Structure
```
parksmart/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Admin controllers
│   │   └── User/           # User controllers
│   └── Models/             # Eloquent models
├── database/
│   ├── migrations/         # Database migrations
│   └── database.sqlite     # SQLite database file
├── resources/
│   └── views/
│       ├── admin/          # Admin views
│       ├── auth/           # Authentication views
│       └── user/           # User views
├── routes/
│   └── web.php            # Web routes
└── public/                # Public assets
```

---

## 🗄️ Database Schema

### Key Tables:
- **User** - User accounts (both regular users and admins)
- **parking_slots** - Parking slot information
- **Reservation** - User bookings and reservations
- **Payment** - Payment records
- **Vehicle** - User vehicle information

---

## 🔧 Key Routes

### Public Routes:
- `/` - Landing page
- `/login` - User login
- `/register` - User registration

### User Routes (Authenticated):
- `/dashboard` - User dashboard
- `/slots` - View available parking slots
- `/my-reservations` - View user's bookings
- `/slots/{id}/book` - Book a specific slot

### Admin Routes:
- `/admin/login` - Admin login
- `/admin/dashboard` - Admin dashboard (to be implemented)

---

## 🎨 UI/UX Features

- Modern purple gradient theme
- Responsive design (mobile-friendly)
- Real-time timer (updates every second)
- Real-time cost calculator
- Smooth animations and transitions
- Organized by floor tabs
- Color-coded status badges

---

## 🐛 Troubleshooting

### Issue: "No slots available"
**Solution:** Run the Tinker command to create slots (Step 5)

### Issue: "Admin access required"
**Solution:** Make sure you created the admin account with `role = 'admin'` (Step 6)

### Issue: "Slot stays occupied after payment"
**Solution:** Clear cache with `php artisan cache:clear` and try again

### Issue: Database errors
**Solution:** 
```bash
php artisan migrate:fresh
```
Then re-run Steps 5 & 6 to recreate slots and admin

---

## 👥 Team Roles

- **Member 1:** User-side functionality (Completed ✅)
  - Authentication
  - Booking system
  - Real-time timer & payment
  - UI/UX design

- **Member 2:** Admin dashboard (Pending 🔧)
  - Slot management
  - User management
  - Reservation overview
  - Reports & analytics

---

## 📝 Important Notes

1. **Database:** The project uses SQLite. The `database.sqlite` file is NOT pushed to GitHub. Each team member needs to run migrations and seeders.

2. **Environment:** The `.env` file is NOT in GitHub. Copy from `.env.example` and configure.

3. **Admin Password:** Change the default admin password in production!

4. **Payment:** Currently simulated (no real payment gateway). Click "Complete Payment" to mark as paid.

5. **Foreign Keys:** Some foreign key constraints were removed for flexibility during development.

---

## 🚧 To-Do (For Next Team Member)

### Admin Dashboard Features:
- [ ] View all parking slots with status
- [ ] Add/Edit/Delete parking slots
- [ ] View all active reservations
- [ ] View completed reservations with payment status
- [ ] View all registered users
- [ ] Generate revenue reports
- [ ] Dashboard with statistics (total revenue, occupancy rate, etc.)
- [ ] Search and filter functionality

### Admin Dashboard UI:
- [ ] Modern admin theme (match user-side purple theme)
- [ ] Responsive tables
- [ ] Charts/graphs for analytics
- [ ] Quick stats cards

---

## 💡 Tips for Admin Dashboard Developer

1. **Models already exist:** Check `app/Models/` for ParkingSlot, Reservation, User, etc.

2. **Use existing controllers:** `app/Http/Controllers/Admin/` has some scaffolding

3. **Routes are set up:** Check `routes/web.php` for admin routes

4. **Database structure:** 
   - `parking_slots` table (primary key: `id`)
   - `Reservation` table (primary key: `reservationID`)
   - `User` table (primary key: `userID`)

5. **Key relationships:**
   - Reservation belongs to User
   - Reservation belongs to ParkingSlot
   - User has many Reservations

---

## 📞 Need Help?

If you encounter issues:
1. Check the Troubleshooting section
2. Clear cache: `php artisan cache:clear`
3. Check Laravel logs: `storage/logs/laravel.log`
4. Contact team members

---

## 📄 License

This project is for educational purposes (Group Project).

---

**Happy Coding! 🚀**