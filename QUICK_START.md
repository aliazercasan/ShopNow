# 🚀 Quick Start Guide

Get ShopNow running in 5 minutes!

## Prerequisites Check

Before starting, make sure you have:
- ✅ PHP 8.2+ installed
- ✅ Composer installed
- ✅ Node.js & NPM installed
- ✅ MySQL running

## 5-Minute Setup

### Step 1: Create Database (1 minute)

Open your MySQL client and run:
```sql
CREATE DATABASE shopnow;
```

Or use phpMyAdmin/MySQL Workbench to create a database named `shopnow`.

### Step 2: Configure Environment (30 seconds)

The `.env` file should already exist. Just verify these lines:
```env
DB_DATABASE=shopnow
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

### Step 3: Install & Setup (2 minutes)

Run these commands:
```bash
# Install dependencies (if not already done)
composer install
npm install

# Setup database
php artisan migrate:fresh --seed

# Link storage
php artisan storage:link

# Build assets
npm run build
```

### Step 4: Start Server (30 seconds)

```bash
php artisan serve
```

### Step 5: Open Browser (30 seconds)

Visit: **http://localhost:8000**

## 🎉 You're Done!

## Test It Out

### Try as Customer:
1. Click "Register" → Create account
2. Browse products
3. Add items to cart
4. Checkout and place order
5. View your orders

### Try as Admin:
1. Click "Login"
2. Email: `admin@shopnow.com`
3. Password: `password`
4. Click "Admin" in navigation
5. Manage products and orders

## What You Get

✅ **12 Sample Products** across 5 categories
✅ **2 Test Accounts** (admin + customer)
✅ **Full E-Commerce Features** ready to use
✅ **Beautiful UI** with Tailwind CSS
✅ **Responsive Design** works on all devices

## Common First-Time Issues

### "Database not found"
**Fix**: Create the database first
```sql
CREATE DATABASE shopnow;
```

### "Access denied for user"
**Fix**: Update `.env` with correct MySQL password
```env
DB_PASSWORD=your_actual_password
```

### "npm: command not found"
**Fix**: Install Node.js from https://nodejs.org

### "composer: command not found"
**Fix**: Install Composer from https://getcomposer.org

## Next Steps

After setup:

1. **Explore the Admin Panel**
   - Login as admin
   - Create a new product
   - Upload an image
   - Manage orders

2. **Test the Shopping Flow**
   - Browse products
   - Add to cart
   - Complete checkout
   - View order history

3. **Customize**
   - Edit views in `resources/views/`
   - Modify styles in `resources/css/app.css`
   - Add features in controllers

## Development Mode

For active development with hot reload:

**Terminal 1:**
```bash
php artisan serve
```

**Terminal 2:**
```bash
npm run dev
```

Now changes to CSS/JS will auto-reload!

## Need Help?

- 📖 Full documentation: `README.md`
- 🔧 Detailed setup: `SETUP_GUIDE.md`
- ✅ Testing checklist: `DEPLOYMENT_CHECKLIST.md`
- 📊 Project overview: `PROJECT_SUMMARY.md`

## Quick Reference

### URLs
- **Home**: http://localhost:8000
- **Products**: http://localhost:8000/products
- **Cart**: http://localhost:8000/cart
- **Login**: http://localhost:8000/login
- **Admin**: http://localhost:8000/admin/products

### Test Credentials
```
Admin:
Email: admin@shopnow.com
Password: password

Customer:
Email: customer@shopnow.com
Password: password
```

### Useful Commands
```bash
# Reset everything
php artisan migrate:fresh --seed

# Clear caches
php artisan cache:clear

# Rebuild assets
npm run build

# View routes
php artisan route:list
```

## Troubleshooting

### Site not loading?
1. Check if `php artisan serve` is running
2. Try http://127.0.0.1:8000 instead

### Styles not showing?
1. Run `npm run build`
2. Hard refresh browser (Ctrl+F5)

### Database errors?
1. Check MySQL is running
2. Verify `.env` credentials
3. Run `php artisan migrate:fresh --seed`

## Success Indicators

You'll know it's working when:
- ✅ Home page loads with products
- ✅ You can click on products
- ✅ Cart functionality works
- ✅ Login/register works
- ✅ Admin panel is accessible

## Have Fun! 🎊

You now have a fully functional e-commerce platform. Start exploring, testing, and customizing!

---

**Pro Tip**: Keep `SETUP_GUIDE.md` open for detailed explanations of any step.
