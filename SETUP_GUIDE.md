# Quick Setup Guide

## Step-by-Step Setup

### 1. Database Setup

**Option A: Using MySQL Command Line**
```bash
mysql -u root -p
CREATE DATABASE shopnow;
EXIT;
```

**Option B: Using phpMyAdmin**
1. Open phpMyAdmin in your browser
2. Click "New" in the left sidebar
3. Enter database name: `shopnow`
4. Click "Create"

**Option C: Using MySQL Workbench**
1. Open MySQL Workbench
2. Connect to your MySQL server
3. Click "Create a new schema" icon
4. Name it `shopnow`
5. Click "Apply"

### 2. Configure Environment

Make sure your `.env` file has the correct database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shopnow
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

### 3. Run Migrations

```bash
php artisan migrate:fresh --seed
```

This will:
- Create all database tables
- Seed sample data (categories, products, users)

### 4. Start the Application

**Terminal 1 - Laravel Server:**
```bash
php artisan serve
```

**Terminal 2 - Vite Dev Server (for hot reload):**
```bash
npm run dev
```

Or just build once:
```bash
npm run build
```

### 5. Access the Application

Open your browser and visit: `http://localhost:8000`

## Test Accounts

### Admin Access
- URL: `http://localhost:8000/login`
- Email: `admin@shopnow.com`
- Password: `password`

After login, you'll see an "Admin" link in the navigation.

### Customer Access
- URL: `http://localhost:8000/login`
- Email: `customer@shopnow.com`
- Password: `password`

Or register a new account at: `http://localhost:8000/register`

## Testing the Application

### As a Customer:
1. Browse products at `/products`
2. Click on a product to view details
3. Add products to cart
4. View cart at `/cart`
5. Login if not authenticated
6. Proceed to checkout
7. Fill in shipping information
8. Place order
9. View order history at `/orders`

### As an Admin:
1. Login with admin credentials
2. Click "Admin" in navigation
3. Manage products:
   - Create new products
   - Edit existing products
   - Delete products
   - Toggle active status
4. View orders at `/admin/orders`
5. Update order status (pending → processing → completed)

## Common Issues

### Issue: Database connection error
**Solution**: 
- Make sure MySQL is running
- Check database credentials in `.env`
- Verify database `shopnow` exists

### Issue: Assets not loading
**Solution**:
```bash
npm run build
php artisan storage:link
```

### Issue: Permission errors
**Solution** (Linux/Mac):
```bash
chmod -R 775 storage bootstrap/cache
```

### Issue: "Class not found" errors
**Solution**:
```bash
composer dump-autoload
```

## Development Workflow

### Making Changes

1. **Backend Changes** (Controllers, Models, Routes):
   - Edit files in `app/` directory
   - Changes are reflected immediately
   - No rebuild needed

2. **Frontend Changes** (Views, CSS, JS):
   - Edit files in `resources/` directory
   - If using `npm run dev`: Changes auto-reload
   - If using `npm run build`: Run build command after changes

3. **Database Changes**:
   - Create migration: `php artisan make:migration migration_name`
   - Run migration: `php artisan migrate`
   - Rollback: `php artisan migrate:rollback`

### Adding New Products (Admin)

1. Login as admin
2. Go to `/admin/products`
3. Click "Add Product"
4. Fill in:
   - Product name
   - Category
   - Description
   - Price
   - Stock quantity
   - Upload image (optional)
   - Set active status
5. Click "Create Product"

### Managing Orders (Admin)

1. Go to `/admin/orders`
2. Click "View" on any order
3. Update status:
   - **Pending**: Order just placed
   - **Processing**: Order being prepared
   - **Completed**: Order delivered
   - **Cancelled**: Order cancelled

## Production Deployment

Before deploying to production:

1. **Update environment**:
```env
APP_ENV=production
APP_DEBUG=false
```

2. **Optimize application**:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

3. **Build assets**:
```bash
npm run build
```

4. **Set proper permissions**:
```bash
chmod -R 755 storage bootstrap/cache
```

5. **Configure web server** (Apache/Nginx) to point to `public/` directory

## Need Help?

- Check Laravel documentation: https://laravel.com/docs
- Check Tailwind CSS docs: https://tailwindcss.com/docs
- Check Alpine.js docs: https://alpinejs.dev/start-here

## Next Steps

After setup, you can:
- Customize the design in `resources/views/`
- Add more products via admin panel
- Test the complete checkout flow
- Modify business logic in controllers
- Add new features as needed
