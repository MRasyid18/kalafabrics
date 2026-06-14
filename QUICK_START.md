# Kala Fabrics - Quick Start Guide

## Prerequisites
- PHP 8.2 or higher
- MySQL 8.0 or higher
- Composer installed
- Laragon or similar local development environment

---

## Initial Setup

### 1. Clone/Access Project
```bash
cd c:\laragon\www\kalafabrics
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Create Environment File
```bash
copy .env.example .env
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Configure Database
Edit `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kalafabrics
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Run Migrations & Seeding
```bash
php artisan migrate:fresh --seed
```

This will:
- Create all 17 database tables
- Seed demo data with 4 test users
- Create sample products and categories

---

## Running the Application

### Start Development Server
```bash
php artisan serve
```

Server runs at: `http://localhost:8000`

---

## API Quick Test

### 1. Get Public Products
```bash
curl http://localhost:8000/api/v1/public/products
```

### 2. Login as Demo B2C User
```bash
curl -X POST http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "member@kalafabrics.id",
    "password": "password"
  }'
```

**Response** will include `token` field.

### 3. Use Token for Authenticated Requests
```bash
curl -X GET http://localhost:8000/api/v1/auth/me \
  -H "Authorization: Bearer {token_from_login}"
```

---

## Demo Test Accounts

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@kalafabrics.id | admin123 |
| B2C Member | member@kalafabrics.id | password |
| B2B Partner | partner@kalafabrics.id | password |
| Ranger | ranger@kalafabrics.id | password |

---

## Key API Endpoints

### Public (No Auth Required)
- `GET /api/v1/public/products` - Browse products
- `GET /api/v1/public/categories` - Get categories
- `GET /api/v1/public/leaderboard` - View B2B rankings
- `GET /api/v1/public/impact-metrics` - Environmental stats
- `GET /api/v1/public/workshops` - Browse workshops

### Authentication
- `POST /api/v1/auth/register` - New user signup
- `POST /api/v1/auth/login` - User login
- `POST /api/v1/auth/logout` - User logout (requires token)
- `GET /api/v1/auth/me` - Get current user (requires token)

### B2C Member Features
- `GET /api/v1/orders` - View my orders
- `POST /api/v1/orders` - Create new order
- `GET /api/v1/my-points` - Check points balance
- `POST /api/v1/workshops/{id}/register` - Register for workshop

### B2B Partner Features
- `GET /api/v1/b2b/profile` - View company profile
- `POST /api/v1/donations` - Submit waste donation
- `GET /api/v1/donations` - View donation history
- `POST /api/v1/b2b-orders` - Create bulk/white-label order

### Ranger Features
- `GET /api/v1/volunteer-tasks` - View available tasks
- `POST /api/v1/volunteer-tasks/{id}/assign` - Take a task
- `GET /api/v1/my-assignments` - View my tasks

### Admin Features
- `GET /admin/dashboard` - Dashboard overview
- `GET /admin/users` - Manage users
- `GET /admin/donations` - Verify waste donations
- `POST /admin/users/{id}/verify-b2b` - Approve B2B partner

---

## Project Structure

```
app/
├── Models/              (15 models for database entities)
├── Http/
│   ├── Controllers/Api/ (API controllers)
│   ├── Middleware/      (CheckRole authorization)
│   └── Resources/       (API response formatting)
database/
├── migrations/          (17 table migrations)
└── seeders/            (Demo data seeding)
routes/
└── api.php            (API endpoint definitions)
```

---

## Common Commands

### Database
```bash
php artisan migrate              # Run migrations
php artisan migrate:fresh        # Reset database
php artisan migrate:fresh --seed # Reset with demo data
php artisan db:seed              # Seed existing database
```

### Development
```bash
php artisan serve               # Start dev server
php artisan tinker              # Interactive shell
php artisan storage:link        # Link public storage
```

### Cache & Config
```bash
php artisan cache:clear         # Clear cache
php artisan config:cache        # Cache config files
php artisan route:list          # Show all routes
```

---

## Making Your First API Call

### Step 1: Register a New User
```bash
POST http://localhost:8000/api/v1/auth/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "role": "b2c"
}
```

### Step 2: Login with Email/Password
```bash
POST http://localhost:8000/api/v1/auth/login
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "password123"
}
```

**Save the returned `token` value**

### Step 3: Use Token for Authenticated Requests
```bash
GET http://localhost:8000/api/v1/auth/me
Authorization: Bearer {your_token_here}
Content-Type: application/json
```

---

## Useful Tools for API Testing

### Postman
- Import the API collection for easier testing
- Pre-configure authorization tokens
- Save requests for team use

### Insomnia
- Lightweight alternative to Postman
- Good for quick API testing

### curl (Command Line)
- Built-in on most systems
- Good for scripting and automation

### Thunder Client (VS Code)
- Built into VS Code
- Lightweight and fast

---

## Troubleshooting

### "SQLSTATE[HY000]: General error: 1824"
**Issue**: Foreign key references before table exists
**Solution**: Migrations are already fixed - just run `php artisan migrate:fresh --seed`

### "Class not found" Error
**Issue**: Autoloader not updated
**Solution**: Run `composer dump-autoload`

### "Base table or view already exists"
**Issue**: Trying to create table that exists
**Solution**: Use `php artisan migrate:fresh` to reset everything

### Database Connection Error
**Issue**: Can't connect to MySQL
**Solution**: Check `.env` database credentials match your setup

### Port 8000 Already in Use
**Issue**: Another service using port 8000
**Solution**: `php artisan serve --port=8001`

---

## File Locations

- **Configuration**: `.env`
- **Routes**: `routes/api.php`
- **Controllers**: `app/Http/Controllers/Api/`
- **Models**: `app/Models/`
- **Migrations**: `database/migrations/`
- **Database Seeder**: `database/seeders/DatabaseSeeder.php`
- **Documentation**: `API_DOCUMENTATION.md`
- **Implementation Info**: `IMPLEMENTATION_SUMMARY.md`

---

## Next Development Steps

1. **Implement remaining controllers** - Complete the stub controllers
2. **Add business logic** - Points calculation, order processing
3. **Setup admin features** - User verification, metrics updates
4. **Add validation** - Input validation on all endpoints
5. **Create tests** - Feature and unit tests
6. **Frontend development** - Connect with Vue/React
7. **Deployment** - Set up production environment

---

## Support Documentation

- **API Docs**: See `API_DOCUMENTATION.md` for all endpoints
- **Implementation Status**: See `IMPLEMENTATION_SUMMARY.md` for progress
- **Laravel Docs**: https://laravel.com/docs/11.x
- **Sanctum Auth**: https://laravel.com/docs/11.x/sanctum

---

## Quick Tips

💡 **Always include token in requests** - Most endpoints require `Authorization: Bearer {token}` header

💡 **Check role permissions** - Different roles have access to different endpoints

💡 **Use pagination** - List endpoints support `?page=1` parameter

💡 **Filter products** - Use `?category=1&search=bag` to filter products

💡 **Test with demo accounts** - Login as different roles to test role-based features

---

**Happy coding! 🚀**

For issues or questions, refer to `API_DOCUMENTATION.md` or `IMPLEMENTATION_SUMMARY.md`
