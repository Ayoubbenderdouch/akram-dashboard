# Akram Dashboard

A comprehensive B2B e-commerce platform built with Laravel 12.x, featuring an admin dashboard and REST APIs for mobile applications.

## Features

### Admin Dashboard (Web)
- Dashboard with statistics (users, products, orders, revenue)
- User management (view, search, order history)
- Product management (CRUD operations with image uploads)
- Order management (view, filter, update status)
- Responsive design with Tailwind CSS

### Mobile App APIs
- User authentication (register, login, logout)
- Product browsing with pagination
- Order placement with B2B rules (minimum 10 pieces)
- Order history and total spending
- User profile management
- Secure Bearer token authentication via Laravel Sanctum

## Requirements

- PHP 8.2 or higher
- Composer
- MySQL 8.0 or higher
- XAMPP (for local development)

## Installation & Setup

### 1. Install Dependencies
```bash
composer install
```

### 2. Environment Configuration
The `.env` file is already configured with the following database settings:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=Akram_Dashboard
DB_USERNAME=root
DB_PASSWORD=
```

Make sure your XAMPP MySQL is running on port 3307 and the `Akram_Dashboard` database exists.

### 3. Generate Application Key
```bash
php artisan key:generate
```

### 4. Run Migrations & Seeders
```bash
php artisan migrate --seed
```

This will create all necessary tables and populate them with sample data:
- 3 sample users
- 5 sample products (Algerian-themed)
- 5 sample orders

### 5. Create Storage Symlink
```bash
php artisan storage:link
```

### 6. Start Development Server
```bash
php artisan serve
```

The application will be available at: `http://localhost:8000`

## Default Test Credentials

### Sample Users (for API testing)
1. **Ahmed Benali**
   - Phone: `0551234567`
   - Email: `ahmed.benali@example.dz`
   - Password: `password123`

2. **Fatima Khelil**
   - Phone: `0661234567`
   - Email: `fatima.khelil@example.dz`
   - Password: `password123`

3. **Karim Hamidi**
   - Phone: `0771234567`
   - Email: `karim.hamidi@example.dz`
   - Password: `password123`

## API Documentation

Complete API documentation is available in `api-docs.md` with:
- All endpoints with request/response examples
- Authentication flow
- Error handling
- Postman testing guide

### Quick API Test
1. Register or login to get a token
2. Use the token in Authorization header: `Bearer {token}`
3. Test endpoints via Postman or any API client

**Base URL:** `http://localhost:8000/api`

## Project Structure

```
Akram_Dashboard/
├── app/
│   ├── Http/Controllers/
│   │   ├── Api/                      # API Controllers
│   │   │   ├── AuthController.php
│   │   │   ├── ProductController.php
│   │   │   ├── OrderController.php
│   │   │   └── UserController.php
│   │   ├── DashboardController.php   # Web Dashboard
│   │   ├── UserManagementController.php
│   │   ├── ProductManagementController.php
│   │   └── OrderManagementController.php
│   └── Models/
│       ├── User.php
│       ├── Product.php
│       └── Order.php
├── database/
│   ├── migrations/
│   │   ├── *_create_users_table.php
│   │   ├── *_create_products_table.php
│   │   └── *_create_orders_table.php
│   └── seeders/
│       ├── UserSeeder.php
│       ├── ProductSeeder.php
│       └── OrderSeeder.php
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php
│   └── dashboard/
│       ├── index.blade.php
│       ├── users/
│       ├── products/
│       └── orders/
├── routes/
│   ├── api.php                       # API Routes
│   └── web.php                       # Web Dashboard Routes
├── api-docs.md                       # Complete API Documentation
└── README.md
```

## Database Schema

### Users Table
- id, name, surname, phone_number (unique), email (unique), password, timestamps

### Products Table
- id, name, bio, image_url, price, min_quantity (default: 10), stock, timestamps

### Orders Table
- id, user_id (foreign), product_id (foreign), quantity, total_price, status (pending/paid/shipped), timestamps

## Key Features Implementation

### 1. B2B Logic
- Minimum order quantity enforced: 10 pieces
- Validation at API level
- Automatic stock management

### 2. Authentication
- Laravel Sanctum for API token-based auth
- Algerian phone number validation (05/06/07 + 8 digits)
- Secure password hashing

### 3. Image Upload
- Product images stored in `storage/app/public/products`
- Accessible via symlink at `public/storage`
- Automatic old image deletion on update

### 4. Dashboard Features
- Real-time statistics
- Search and filter functionality
- Responsive UI with Tailwind CSS
- Order status management

## Development Notes

### Running Migrations
If you need to reset the database:
```bash
php artisan migrate:fresh --seed
```

### Testing APIs
Use the provided API documentation in `api-docs.md` with Postman or similar tools.

### Adding New Products
Access the dashboard at `http://localhost:8000/products/create`

## Security Features

- Password hashing with bcrypt
- CSRF protection for web routes
- API token authentication
- Input validation and sanitization
- SQL injection protection via Eloquent ORM

## Localization

- Dashboard UI: English
- Database content: Sample Algerian products
- Phone validation: Algerian format
- Future mobile app: French (API supports any language)

## Technologies Used

- **Backend:** Laravel 12.x
- **Database:** MySQL
- **Authentication:** Laravel Sanctum
- **Frontend:** Blade Templates, Tailwind CSS
- **Storage:** Local filesystem with symlinks

## Support & Documentation

- Laravel Documentation: https://laravel.com/docs/12.x
- API Documentation: See `api-docs.md`
- Sanctum Documentation: https://laravel.com/docs/12.x/sanctum

## License

This project is proprietary software for Akram Dashboard.

---

**Generated with Laravel 12.x**
*Ready for production deployment with proper environment configuration*
