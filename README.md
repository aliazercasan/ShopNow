# ShopNow - Simple E-Commerce System

A clean, modern e-commerce platform built with Laravel, Tailwind CSS, and Alpine.js.

## Features

### Customer Features
- ✅ User registration and authentication
- ✅ Browse products with search and category filters
- ✅ View detailed product information
- ✅ Add products to cart (guest and authenticated)
- ✅ Update cart quantities
- ✅ Checkout and place orders
- ✅ View order history
- ✅ Responsive mobile-first design

### Admin Features
- ✅ Product management (CRUD)
- ✅ Order management
- ✅ Update order status
- ✅ View customer information

## Tech Stack

- **Backend**: Laravel 12
- **Frontend**: Blade Templates, Tailwind CSS 4, Alpine.js
- **Authentication**: Laravel Sanctum
- **Database**: MySQL
- **Assets**: Vite

## Installation

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL

### Setup Steps

1. **Clone the repository**
```bash
git clone <repository-url>
cd ShopNow
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install Node dependencies**
```bash
npm install
```

4. **Environment setup**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure database**
Edit `.env` file and set your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shopnow
DB_USERNAME=root
DB_PASSWORD=your_password
```

6. **Create database**
Create a MySQL database named `shopnow`:
```sql
CREATE DATABASE shopnow;
```

Or use your MySQL client (phpMyAdmin, MySQL Workbench, etc.)

7. **Run migrations and seed data**
```bash
php artisan migrate:fresh --seed
```

8. **Create storage link**
```bash
php artisan storage:link
```

9. **Build assets**
```bash
npm run build
```

10. **Start development server**
```bash
php artisan serve
```

Visit: `http://localhost:8000`

## Default Credentials

### Admin Account
- Email: `admin@shopnow.com`
- Password: `password`

### Customer Account
- Email: `customer@shopnow.com`
- Password: `password`

## Development

### Run development server with hot reload
```bash
npm run dev
```

In another terminal:
```bash
php artisan serve
```

### Run tests
```bash
php artisan test
```

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # Admin controllers
│   │   ├── AuthController.php
│   │   ├── CartController.php
│   │   ├── OrderController.php
│   │   └── ProductController.php
│   └── Middleware/
│       └── AdminMiddleware.php
├── Models/
│   ├── CartItem.php
│   ├── Category.php
│   ├── Order.php
│   ├── OrderItem.php
│   ├── Product.php
│   └── User.php
database/
├── migrations/
└── seeders/
resources/
├── css/
│   └── app.css
├── js/
│   └── app.js
└── views/
    ├── admin/              # Admin views
    ├── auth/               # Authentication views
    ├── cart/               # Cart views
    ├── orders/             # Order views
    ├── products/           # Product views
    └── layouts/
        └── app.blade.php   # Main layout
```

## Database Schema

### Users
- id, name, email, password, role (customer/admin)

### Categories
- id, name, slug, description

### Products
- id, category_id, name, slug, description, price, stock, image, is_active

### Cart Items
- id, user_id, session_id, product_id, quantity

### Orders
- id, user_id, order_number, total_amount, status, customer details, shipping_address

### Order Items
- id, order_id, product_id, quantity, price

## Security Features

- ✅ Input validation on all forms
- ✅ CSRF protection
- ✅ Password hashing
- ✅ Role-based access control
- ✅ SQL injection prevention (Eloquent ORM)
- ✅ XSS protection (Blade templating)

## User Flow

1. **Guest User**: Browse products → Add to cart → Login/Register → Checkout
2. **Customer**: Login → Browse → Add to cart → Checkout → View orders
3. **Admin**: Login → Manage products → Manage orders → Update status

## API Endpoints

All routes are defined in `routes/web.php`:

### Public Routes
- `GET /products` - Browse products
- `GET /products/{product}` - View product details
- `GET /cart` - View cart
- `POST /cart/add/{product}` - Add to cart

### Authenticated Routes
- `GET /orders` - View order history
- `GET /orders/checkout` - Checkout page
- `POST /orders` - Place order
- `GET /orders/{order}` - View order details

### Admin Routes (requires admin role)
- `GET /admin/products` - Manage products
- `POST /admin/products` - Create product
- `PUT /admin/products/{product}` - Update product
- `DELETE /admin/products/{product}` - Delete product
- `GET /admin/orders` - View all orders
- `PATCH /admin/orders/{order}/status` - Update order status

## Future Enhancements

- Payment gateway integration (Stripe, PayPal)
- Product reviews and ratings
- Wishlist functionality
- Product variants (size, color)
- Advanced search and filters
- Email notifications
- Order tracking
- Discount codes/coupons
- Product images gallery
- Admin dashboard with analytics

## Deployment

### InfinityFree Hosting

This project is deployed at: **https://shopnow.kesug.com**

#### Quick Deployment Steps

1. **Build assets for production**
```bash
npm run build
```

2. **Upload files to InfinityFree**
   - Upload all Laravel files to `htdocs/`
   - **IMPORTANT**: Upload `public/build/` folder with CSS/JS files
   - Upload `.env.production` as `.env` (update database credentials)

3. **Check deployment status**
   - Visit: `https://shopnow.kesug.com/check-deployment.php`
   - This will show you what's missing or misconfigured

4. **Clear cache**
   - Visit: `https://shopnow.kesug.com/clear-all-cache`

#### Deployment Files

- **QUICK_FIX.md** - Fast solution for CSS/JS not loading
- **DEPLOYMENT_GUIDE.md** - Complete deployment guide
- **UPLOAD_CHECKLIST.txt** - Step-by-step checklist
- **.env.production** - Production environment template
- **public/check-deployment.php** - Deployment verification tool

#### Common Issues

| Issue | Solution |
|-------|----------|
| CSS/JS not loading | Upload `public/build/` folder |
| 500 Error | Set storage folder permissions to 755 |
| Database Error | Update .env with InfinityFree credentials |
| Images not showing | Upload storage files to public/storage/ |

For detailed deployment instructions, see **DEPLOYMENT_GUIDE.md**

## License

MIT License

## Support

For issues and questions, please open an issue on GitHub.
