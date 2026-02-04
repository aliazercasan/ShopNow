# ShopNow Architecture

## System Architecture Overview

```
┌─────────────────────────────────────────────────────────────┐
│                        FRONTEND LAYER                        │
│  ┌────────────┐  ┌────────────┐  ┌────────────────────┐    │
│  │  Blade     │  │  Tailwind  │  │     Alpine.js      │    │
│  │ Templates  │  │    CSS     │  │   (Interactivity)  │    │
│  └────────────┘  └────────────┘  └────────────────────┘    │
└─────────────────────────────────────────────────────────────┘
                            ↕
┌─────────────────────────────────────────────────────────────┐
│                      ROUTING LAYER                           │
│                      (routes/web.php)                        │
│  ┌──────────┐  ┌──────────┐  ┌──────────┐  ┌──────────┐   │
│  │  Public  │  │   Auth   │  │ Customer │  │  Admin   │   │
│  │  Routes  │  │  Routes  │  │  Routes  │  │  Routes  │   │
│  └──────────┘  └──────────┘  └──────────┘  └──────────┘   │
└─────────────────────────────────────────────────────────────┘
                            ↕
┌─────────────────────────────────────────────────────────────┐
│                    MIDDLEWARE LAYER                          │
│  ┌──────────┐  ┌──────────┐  ┌──────────────────────┐     │
│  │   Auth   │  │   CSRF   │  │  AdminMiddleware     │     │
│  └──────────┘  └──────────┘  └──────────────────────┘     │
└─────────────────────────────────────────────────────────────┘
                            ↕
┌─────────────────────────────────────────────────────────────┐
│                    CONTROLLER LAYER                          │
│  ┌──────────────┐  ┌──────────────┐  ┌─────────────────┐  │
│  │     Auth     │  │   Product    │  │      Cart       │  │
│  │  Controller  │  │  Controller  │  │   Controller    │  │
│  └──────────────┘  └──────────────┘  └─────────────────┘  │
│  ┌──────────────┐  ┌──────────────┐  ┌─────────────────┐  │
│  │    Order     │  │    Admin     │  │   Admin Order   │  │
│  │  Controller  │  │   Product    │  │   Controller    │  │
│  └──────────────┘  └──────────────┘  └─────────────────┘  │
└─────────────────────────────────────────────────────────────┘
                            ↕
┌─────────────────────────────────────────────────────────────┐
│                      MODEL LAYER                             │
│  ┌──────┐  ┌──────────┐  ┌─────────┐  ┌──────────────┐    │
│  │ User │  │ Category │  │ Product │  │   CartItem   │    │
│  └──────┘  └──────────┘  └─────────┘  └──────────────┘    │
│  ┌──────┐  ┌───────────┐                                   │
│  │Order │  │ OrderItem │                                   │
│  └──────┘  └───────────┘                                   │
└─────────────────────────────────────────────────────────────┘
                            ↕
┌─────────────────────────────────────────────────────────────┐
│                     DATABASE LAYER                           │
│                      (MySQL)                                 │
└─────────────────────────────────────────────────────────────┘
```

## Request Flow

### Customer Product Purchase Flow

```
User Action → Route → Middleware → Controller → Model → Database
                                        ↓
                                    Response
                                        ↓
                                   View (Blade)
                                        ↓
                                   Browser
```

### Detailed Flow Example: Adding to Cart

```
1. User clicks "Add to Cart"
   ↓
2. POST /cart/add/{product}
   ↓
3. CSRF Middleware validates token
   ↓
4. CartController@add
   ↓
5. Validates quantity
   ↓
6. Checks product stock
   ↓
7. Creates/Updates CartItem model
   ↓
8. Saves to database
   ↓
9. Returns redirect with success message
   ↓
10. Blade renders cart page
   ↓
11. Alpine.js handles interactivity
```

## Database Schema

```
┌─────────────┐
│    users    │
├─────────────┤
│ id          │
│ name        │
│ email       │
│ password    │
│ role        │◄────────┐
└─────────────┘         │
                        │
┌─────────────┐         │
│ categories  │         │
├─────────────┤         │
│ id          │         │
│ name        │         │
│ slug        │         │
└─────────────┘         │
      ▲                 │
      │                 │
┌─────────────┐         │
│  products   │         │
├─────────────┤         │
│ id          │         │
│ category_id │─────────┤
│ name        │         │
│ price       │         │
│ stock       │         │
└─────────────┘         │
      ▲                 │
      │                 │
┌─────────────┐         │
│ cart_items  │         │
├─────────────┤         │
│ id          │         │
│ user_id     │─────────┤
│ product_id  │─────────┘
│ quantity    │
└─────────────┘
      
┌─────────────┐
│   orders    │
├─────────────┤
│ id          │
│ user_id     │─────────┐
│ order_number│         │
│ total_amount│         │
│ status      │         │
└─────────────┘         │
      ▲                 │
      │                 │
┌─────────────┐         │
│ order_items │         │
├─────────────┤         │
│ id          │         │
│ order_id    │─────────┘
│ product_id  │
│ quantity    │
│ price       │
└─────────────┘
```

## Component Relationships

### Models & Relationships

```
User
├── hasMany(CartItem)
├── hasMany(Order)
└── isAdmin() method

Category
└── hasMany(Product)

Product
├── belongsTo(Category)
├── hasMany(CartItem)
└── hasMany(OrderItem)

CartItem
├── belongsTo(User)
└── belongsTo(Product)

Order
├── belongsTo(User)
├── hasMany(OrderItem)
└── generateOrderNumber() method

OrderItem
├── belongsTo(Order)
└── belongsTo(Product)
```

## Authentication Flow

```
┌──────────────┐
│   Register   │
└──────┬───────┘
       │
       ▼
┌──────────────┐
│  Validation  │
└──────┬───────┘
       │
       ▼
┌──────────────┐
│ Create User  │
│ (role: customer)
└──────┬───────┘
       │
       ▼
┌──────────────┐
│  Auto Login  │
└──────┬───────┘
       │
       ▼
┌──────────────┐
│   Redirect   │
│  to Products │
└──────────────┘
```

## Authorization Flow

```
Request → Auth Middleware → Check if authenticated
                                    │
                    ┌───────────────┴───────────────┐
                    │                               │
                Authenticated                  Not Authenticated
                    │                               │
                    ▼                               ▼
            Admin Middleware                  Redirect to Login
                    │
        ┌───────────┴───────────┐
        │                       │
    Is Admin              Not Admin
        │                       │
        ▼                       ▼
   Allow Access            403 Forbidden
```

## Cart Management

### Guest Cart (Session-based)
```
Add to Cart → Store with session_id
              ↓
          Cart persists in session
              ↓
          User logs in
              ↓
     Merge with user cart (optional)
```

### Authenticated Cart (User-based)
```
Add to Cart → Store with user_id
              ↓
          Cart persists in database
              ↓
     Available across devices
```

## Order Processing Flow

```
1. User in Cart
   ↓
2. Click Checkout
   ↓
3. Verify Authentication
   ↓
4. Display Checkout Form
   ↓
5. User Fills Details
   ↓
6. Submit Order
   ↓
7. Validate Input
   ↓
8. Begin Transaction
   ↓
9. Create Order Record
   ↓
10. Create Order Items
    ↓
11. Decrement Product Stock
    ↓
12. Clear Cart
    ↓
13. Commit Transaction
    ↓
14. Show Order Confirmation
```

## Admin Panel Structure

```
Admin Dashboard
├── Products Management
│   ├── List Products
│   ├── Create Product
│   ├── Edit Product
│   └── Delete Product
└── Orders Management
    ├── List Orders
    ├── View Order Details
    └── Update Order Status
```

## Security Layers

```
┌─────────────────────────────────────┐
│     Input Validation Layer          │
│  (Request Validation Rules)         │
└─────────────────────────────────────┘
              ↓
┌─────────────────────────────────────┐
│     Authentication Layer            │
│  (Laravel Sanctum)                  │
└─────────────────────────────────────┘
              ↓
┌─────────────────────────────────────┐
│     Authorization Layer             │
│  (Middleware, Policies)             │
└─────────────────────────────────────┘
              ↓
┌─────────────────────────────────────┐
│     CSRF Protection                 │
│  (Token Verification)               │
└─────────────────────────────────────┘
              ↓
┌─────────────────────────────────────┐
│     XSS Protection                  │
│  (Blade Escaping)                   │
└─────────────────────────────────────┘
              ↓
┌─────────────────────────────────────┐
│     SQL Injection Prevention        │
│  (Eloquent ORM)                     │
└─────────────────────────────────────┘
```

## File Upload Flow

```
Admin Uploads Image
       ↓
Validation (type, size)
       ↓
Store in storage/app/public/products
       ↓
Create symbolic link (storage:link)
       ↓
Save path in database
       ↓
Display via public/storage/products
```

## Frontend Architecture

```
┌─────────────────────────────────────┐
│         Layout (app.blade.php)      │
│  ┌───────────────────────────────┐  │
│  │       Navigation Bar          │  │
│  └───────────────────────────────┘  │
│  ┌───────────────────────────────┐  │
│  │      Flash Messages           │  │
│  └───────────────────────────────┘  │
│  ┌───────────────────────────────┐  │
│  │      @yield('content')        │  │
│  │                               │  │
│  │   (Page-specific content)     │  │
│  │                               │  │
│  └───────────────────────────────┘  │
│  ┌───────────────────────────────┐  │
│  │          Footer               │  │
│  └───────────────────────────────┘  │
└─────────────────────────────────────┘
```

## State Management

### Alpine.js Components

```javascript
// Cart Quantity Control
x-data="{ quantity: 1 }"
  ├── Increment button
  ├── Decrement button
  └── Input field

// Product Filters
x-data="{ showFilters: false }"
  ├── Toggle button
  └── Filter panel
```

## Performance Optimizations

```
Database Level
├── Indexes on foreign keys
├── Eager loading (with())
└── Pagination

Application Level
├── Route caching
├── Config caching
└── View caching

Frontend Level
├── Asset minification
├── CSS purging (Tailwind)
└── Lazy loading images
```

## Deployment Architecture

```
┌─────────────────────────────────────┐
│         Web Server (Apache/Nginx)   │
└─────────────────┬───────────────────┘
                  │
┌─────────────────▼───────────────────┐
│         Laravel Application         │
│         (public/ directory)         │
└─────────────────┬───────────────────┘
                  │
┌─────────────────▼───────────────────┐
│         MySQL Database              │
└─────────────────────────────────────┘
```

## Scalability Considerations

```
Current Architecture (MVP)
├── Single server
├── File-based sessions
└── Local file storage

Future Scaling Options
├── Load balancer
├── Database sessions/Redis
├── Cloud storage (S3)
├── CDN for assets
└── Queue workers
```

---

This architecture follows Laravel best practices and MVC pattern, ensuring clean separation of concerns and maintainability.
