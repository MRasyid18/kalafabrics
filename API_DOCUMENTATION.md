# Kala Fabrics API Documentation

## System Overview
Kala Fabrics is a textile waste recycling and upcycling platform with API-first architecture supporting multiple user roles and comprehensive environmental impact tracking.

---

## User Roles

### 1. **Admin** (`admin`)
- Full system management and oversight
- User verification and role management
- Product and workshop management
- Impact metrics updates
- Waste donation verification

### 2. **B2C Member** (`b2c`)
- Consumer of eco-friendly products
- Place orders and track shipments
- Participate in workshops
- Earn and redeem points
- View personal impact contributions

### 3. **B2B Partner** (`b2b`)
- Donate textile waste
- Make bulk purchases
- White-label products with custom branding
- Participate in leaderboard
- Earn partnership points

### 4. **Ranger** (`ranger`)
- Volunteer for environmental campaigns
- Manage waste sorting activities
- Education program support
- Earn volunteer hours and points

---

## Database Schema

### Core Tables

#### `users`
- id, name, email, password, role, points
- Roles: admin, b2c, b2b, ranger
- Authentication via Laravel Sanctum tokens

#### `b2b_profiles`
- Company information for B2B partners
- Verification status and documentation
- Total waste donated tracking
- Status: pending, verified, rejected

#### `categories`
- Product category management
- name, slug, description, image_path, active

#### `products`
- Eco-friendly product catalog
- Price, stock, points rewards
- Product type: b2c, b2b, both
- Bulk discount configuration

#### `orders` / `order_items`
- B2C customer orders
- Status tracking: pending, processing, shipped, delivered
- Points earned per order

#### `waste_donations` / `waste_items`
- B2B waste donation tracking
- Item-level details with condition assessment
- Verification workflow and status

#### `b2b_orders` / `b2b_order_items`
- Bulk and white-label purchases
- Custom branding support
- Order type: bulk_purchase, white_label

#### `user_points`
- Total, redeemed, and available points
- Gamification system

#### `leaderboards`
- B2B partner rankings
- Types: waste_donation, purchases
- Monthly/ongoing rankings

#### `workshops`
- Educational events catalog
- Online and in-person support
- Capacity and registration management

#### `workshop_registrations`
- User participation tracking
- Status: registered, attended, cancelled

#### `volunteer_tasks`
- Volunteer opportunity listings
- Task types: waste_sorting, education_campaign, event_support, content_creation

#### `volunteer_task_assignments`
- Assignment tracking
- Hours commitment and completion

#### `impact_metrics`
- Platform-wide environmental metrics
- Waste collected, carbon saved, water saved
- User and partner statistics

---

## API Endpoints

### Base URL
```
http://localhost:8000/api/v1
```

### Authentication
All protected endpoints require:
```
Authorization: Bearer {token}
Content-Type: application/json
```

---

### PUBLIC ENDPOINTS

#### Get All Products
```http
GET /public/products
```
Query Parameters:
- `category` (int)
- `search` (string)
- `product_type` (string)

Response: Paginated product list

#### Get Product Details
```http
GET /public/products/{id}
```

#### Get Categories
```http
GET /public/categories
```

#### Get B2B Leaderboard
```http
GET /public/leaderboard
```

#### Get Platform Impact Metrics
```http
GET /public/impact-metrics
```

#### List Public Workshops
```http
GET /public/workshops
```

---

### AUTHENTICATION ENDPOINTS

#### Register
```http
POST /auth/register
```
Body:
```json
{
    "name": "string",
    "email": "email@example.com",
    "password": "string (min 8)",
    "password_confirmation": "string",
    "role": "b2c|b2b|ranger"
}
```

#### Login
```http
POST /auth/login
```
Body:
```json
{
    "email": "email@example.com",
    "password": "string"
}
```
Returns: User data + API token

#### Get Current User
```http
GET /auth/me
```
Requires: Authentication

#### Logout
```http
POST /auth/logout
```
Requires: Authentication

#### Update Profile
```http
PUT /profile
```
Body:
```json
{
    "name": "string",
    "email": "email@example.com"
}
```

#### Change Password
```http
POST /profile/change-password
```
Body:
```json
{
    "current_password": "string",
    "password": "string",
    "password_confirmation": "string"
}
```

---

### B2C MEMBER ENDPOINTS

#### Get My Orders
```http
GET /orders
```
Returns: Paginated list of user's orders

#### Create Order
```http
POST /orders
```
Body:
```json
{
    "items": [
        {
            "product_id": 1,
            "quantity": 2
        }
    ],
    "shipping_address": "string",
    "city": "string",
    "postal_code": "string",
    "recipient_name": "string",
    "recipient_phone": "string"
}
```

#### Get Order Details
```http
GET /orders/{id}
```

#### Get Order Invoice
```http
GET /orders/{id}/invoice
```

#### View My Points
```http
GET /my-points
```

#### Get My Workshop Registrations
```http
GET /workshops
```

#### Register for Workshop
```http
POST /workshops/{id}/register
```

#### Unregister from Workshop
```http
DELETE /workshops/{id}/unregister
```

---

### B2B PARTNER ENDPOINTS

#### Get B2B Profile
```http
GET /b2b/profile
```

#### Update B2B Profile
```http
POST /b2b/profile
```
Body:
```json
{
    "company_name": "string",
    "company_registration_number": "string",
    "company_address": "string",
    "city": "string",
    "province": "string",
    "postal_code": "string",
    "phone": "string",
    "contact_person_name": "string",
    "contact_person_phone": "string",
    "contact_person_email": "email",
    "business_description": "string"
}
```

#### Submit Waste Donation
```http
POST /donations
```
Body:
```json
{
    "total_weight_kg": 100.50,
    "donation_address": "string",
    "city": "string",
    "postal_code": "string",
    "contact_person_name": "string",
    "contact_person_phone": "string",
    "scheduled_pickup_date": "2026-06-15 10:00:00",
    "items": [
        {
            "item_description": "Cotton fabric scraps",
            "weight_kg": 50.25,
            "condition": "good"
        }
    ]
}
```

#### View My Donations
```http
GET /donations
```

#### Get Donation Details
```http
GET /donations/{id}
```

#### Create B2B Order (Bulk/White-Label)
```http
POST /b2b-orders
```
Body:
```json
{
    "order_type": "bulk_purchase|white_label",
    "items": [
        {
            "product_id": 1,
            "quantity": 100
        }
    ],
    "delivery_address": "string",
    "city": "string",
    "postal_code": "string",
    "custom_brand_name": "string (for white-label)",
    "custom_logo_path": "string (for white-label)"
}
```

#### View B2B Orders
```http
GET /b2b-orders
```

#### Get B2B Order Invoice
```http
GET /b2b-orders/{id}/invoice
```

#### View B2B Leaderboard
```http
GET /b2b/points-leaderboard
```

---

### RANGER ENDPOINTS

#### Get Volunteer Tasks
```http
GET /volunteer-tasks
```

#### Get My Task Assignments
```http
GET /my-assignments
```

#### Assign Task to Self
```http
POST /volunteer-tasks/{id}/assign
```

#### Complete Task
```http
POST /volunteer-tasks/{id}/complete
```
Body:
```json
{
    "actual_hours": 4,
    "completion_notes": "string"
}
```

---

### ADMIN ENDPOINTS

#### Dashboard Overview
```http
GET /admin/dashboard
```

#### User Management
```http
GET /admin/users
POST /admin/users
GET /admin/users/{id}
PUT /admin/users/{id}
DELETE /admin/users/{id}
```

#### Verify B2B Partner
```http
POST /admin/users/{id}/verify-b2b
```

#### Reject B2B Partner
```http
POST /admin/users/{id}/reject-b2b
```

#### View All Donations
```http
GET /admin/donations
```

#### Verify Donation
```http
POST /admin/donations/{id}/verify
```
Body:
```json
{
    "verification_notes": "string"
}
```

#### Reject Donation
```http
POST /admin/donations/{id}/reject
```

#### Product Management
```http
GET /admin/products
POST /admin/products
PUT /admin/products/{id}
DELETE /admin/products/{id}
```

#### Category Management
```http
GET /admin/categories
POST /admin/categories
PUT /admin/categories/{id}
DELETE /admin/categories/{id}
```

#### Workshop Management
```http
GET /admin/workshops
POST /admin/workshops
PUT /admin/workshops/{id}
DELETE /admin/workshops/{id}
```

#### Volunteer Task Management
```http
GET /admin/volunteer-tasks
POST /admin/volunteer-tasks
PUT /admin/volunteer-tasks/{id}
DELETE /admin/volunteer-tasks/{id}
```

#### Impact Metrics Management
```http
GET /admin/impact-metrics
POST /admin/impact-metrics/update
PUT /admin/impact-metrics/{id}
```

---

## Test Accounts

### Admin
- Email: `admin@kalafabrics.id`
- Password: `admin123`
- Role: `admin`

### B2C Member
- Email: `member@kalafabrics.id`
- Password: `password`
- Role: `b2c`

### B2B Partner
- Email: `partner@kalafabrics.id`
- Password: `password`
- Role: `b2b`

### Ranger
- Email: `ranger@kalafabrics.id`
- Password: `password`
- Role: `ranger`

---

## Error Responses

### Authentication Error (401)
```json
{
    "message": "Unauthenticated."
}
```

### Authorization Error (403)
```json
{
    "message": "Access denied. Insufficient role permissions."
}
```

### Validation Error (422)
```json
{
    "message": "Validation failed",
    "errors": {
        "field_name": ["Error message"]
    }
}
```

### Not Found (404)
```json
{
    "message": "Resource not found"
}
```

---

## Key Features Implemented

✅ **Authentication & Authorization**
- Role-based access control (RBAC)
- Laravel Sanctum API tokens
- Password hashing and secure authentication

✅ **User Management**
- Four role types: Admin, B2C, B2B, Ranger
- User profile management
- Account verification workflows

✅ **Product Catalog**
- Product categorization
- B2C and B2B product support
- Inventory management
- Points-based rewards

✅ **B2C Shopping**
- Order placement and tracking
- Shipment tracking
- Invoice generation
- Points accumulation

✅ **B2B Partnership**
- Waste donation management
- Bulk purchase orders
- White-label customization
- Leaderboard rankings

✅ **Gamification**
- Points system for all roles
- Leaderboard rankings
- Achievement tracking

✅ **Environmental Impact**
- Real-time impact metrics
- Waste collection tracking
- Carbon savings calculation
- Water conservation metrics

✅ **Education & Community**
- Workshop management
- Volunteer task system
- Event registration

---

## Running the Application

### Start the Development Server
```bash
php artisan serve
```

### Access API
```
http://localhost:8000/api/v1/
```

### Run Migrations
```bash
php artisan migrate
```

### Seed Database
```bash
php artisan db:seed
```

### Fresh Install with Seed
```bash
php artisan migrate:fresh --seed
```

---

## Next Steps for Development

1. **Complete Controller Implementations**: Finish implementing all CRUD operations in remaining controllers
2. **API Resources**: Update response formatting for all resource types
3. **Validation Rules**: Add comprehensive input validation
4. **Authorization Policies**: Implement resource-level authorization policies
5. **Event & Notifications**: Add email notifications for key actions
6. **API Rate Limiting**: Implement rate limiting for endpoints
7. **Logging & Monitoring**: Set up comprehensive logging
8. **Testing**: Create feature and unit tests
9. **Frontend Integration**: Connect with Vue/React frontend application
10. **Documentation**: Generate interactive API documentation (OpenAPI/Swagger)

---

**Version**: 1.0  
**Last Updated**: June 10, 2026
**Status**: Development Phase

