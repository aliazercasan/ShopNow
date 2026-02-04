# Deployment Checklist

## Pre-Deployment Setup

### ✅ Database Setup
- [ ] MySQL server is running
- [ ] Database `shopnow` is created
- [ ] Database credentials in `.env` are correct
- [ ] Run: `php artisan migrate:fresh --seed`
- [ ] Verify tables are created
- [ ] Verify sample data is seeded

### ✅ Environment Configuration
- [ ] `.env` file exists (copy from `.env.example` if needed)
- [ ] `APP_KEY` is generated (`php artisan key:generate`)
- [ ] `APP_URL` is set correctly
- [ ] Database credentials are correct
- [ ] `APP_ENV` is set to `local` for development

### ✅ Dependencies
- [ ] PHP dependencies installed: `composer install`
- [ ] Node dependencies installed: `npm install`
- [ ] Storage link created: `php artisan storage:link`

### ✅ Assets
- [ ] Assets compiled: `npm run build`
- [ ] Or dev server running: `npm run dev`

### ✅ Permissions (Linux/Mac only)
- [ ] Storage directory writable: `chmod -R 775 storage`
- [ ] Bootstrap cache writable: `chmod -R 775 bootstrap/cache`

## Testing Checklist

### ✅ Authentication Flow
- [ ] Register new user works
- [ ] Login works
- [ ] Logout works
- [ ] Remember me works
- [ ] Validation errors display correctly
- [ ] Redirects work properly

### ✅ Product Browsing
- [ ] Products page loads
- [ ] Products display correctly
- [ ] Category filter works
- [ ] Search works
- [ ] Pagination works
- [ ] Product detail page works
- [ ] Images display (or placeholder shows)

### ✅ Shopping Cart
- [ ] Add to cart works (guest)
- [ ] Add to cart works (authenticated)
- [ ] Update quantity works
- [ ] Remove item works
- [ ] Cart total calculates correctly
- [ ] Stock validation works
- [ ] Cart persists after login

### ✅ Checkout & Orders
- [ ] Checkout page loads
- [ ] Form validation works
- [ ] Order placement works
- [ ] Stock decrements correctly
- [ ] Cart clears after order
- [ ] Order confirmation shows
- [ ] Order appears in history
- [ ] Order details display correctly

### ✅ Admin Panel
- [ ] Admin can login
- [ ] Admin sees admin link
- [ ] Product list loads
- [ ] Create product works
- [ ] Edit product works
- [ ] Delete product works
- [ ] Image upload works
- [ ] Order list loads
- [ ] Order details show
- [ ] Status update works

### ✅ Security
- [ ] Non-admin cannot access admin routes
- [ ] Users can only see their own orders
- [ ] CSRF protection works
- [ ] Validation prevents invalid data
- [ ] SQL injection prevented
- [ ] XSS prevented

### ✅ UI/UX
- [ ] Responsive on mobile
- [ ] Responsive on tablet
- [ ] Responsive on desktop
- [ ] Navigation works
- [ ] Flash messages display
- [ ] Forms are user-friendly
- [ ] Loading states work
- [ ] Empty states display

## Production Deployment

### ✅ Environment
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Use strong `APP_KEY`
- [ ] Configure production database
- [ ] Set proper `APP_URL`

### ✅ Optimization
- [ ] Run: `composer install --optimize-autoloader --no-dev`
- [ ] Run: `php artisan config:cache`
- [ ] Run: `php artisan route:cache`
- [ ] Run: `php artisan view:cache`
- [ ] Run: `npm run build`

### ✅ Security
- [ ] Remove `.env.example` from production
- [ ] Set proper file permissions
- [ ] Configure HTTPS
- [ ] Set secure session cookies
- [ ] Configure CORS if needed
- [ ] Set up firewall rules

### ✅ Server Configuration
- [ ] Web server points to `public/` directory
- [ ] PHP version 8.2+ installed
- [ ] Required PHP extensions enabled
- [ ] MySQL/MariaDB configured
- [ ] Storage directory writable
- [ ] Logs directory writable

### ✅ Backup
- [ ] Database backup configured
- [ ] File backup configured
- [ ] Backup restoration tested

### ✅ Monitoring
- [ ] Error logging configured
- [ ] Application monitoring set up
- [ ] Database monitoring set up
- [ ] Uptime monitoring configured

## Post-Deployment

### ✅ Verification
- [ ] Site loads correctly
- [ ] All features work
- [ ] No console errors
- [ ] No PHP errors
- [ ] SSL certificate valid
- [ ] Performance acceptable

### ✅ Documentation
- [ ] Admin credentials documented
- [ ] Deployment process documented
- [ ] Backup process documented
- [ ] Recovery process documented

## Quick Commands Reference

### Development
```bash
# Start development
php artisan serve
npm run dev

# Reset database
php artisan migrate:fresh --seed

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Production
```bash
# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Deploy
git pull
composer install --no-dev --optimize-autoloader
npm run build
php artisan migrate --force
php artisan config:cache
```

## Test Accounts

### Admin
- Email: `admin@shopnow.com`
- Password: `password`

### Customer
- Email: `customer@shopnow.com`
- Password: `password`

## Common Issues & Solutions

### Issue: Database connection failed
**Solution**: Check MySQL is running and credentials in `.env`

### Issue: 404 on routes
**Solution**: Run `php artisan route:clear`

### Issue: Assets not loading
**Solution**: Run `npm run build` and `php artisan storage:link`

### Issue: Permission denied
**Solution**: `chmod -R 775 storage bootstrap/cache`

### Issue: Class not found
**Solution**: `composer dump-autoload`

### Issue: Session not working
**Solution**: Check `SESSION_DRIVER` in `.env` and run migrations

## Support Contacts

- Developer: [Your Name]
- Email: [Your Email]
- Documentation: See README.md and SETUP_GUIDE.md

---

**Last Updated**: February 4, 2026
**Version**: 1.0.0
**Status**: Production Ready ✅
