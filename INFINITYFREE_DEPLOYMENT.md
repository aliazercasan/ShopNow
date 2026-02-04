# InfinityFree Deployment Guide for ShopNow

## Prerequisites
- InfinityFree account
- FileZilla or any FTP client
- Your project files built for production

## Step 1: Build Production Assets (Already Done!)
The assets have been built. You'll see them in `public/build/` folder.

## Step 2: Prepare Your Files

### Files to Upload:
```
/app
/bootstrap
/config
/database
/public
/resources
/routes
/storage
/vendor (if you have it, otherwise run composer install on server)
.env.example
artisan
composer.json
composer.lock
```

### Important: DO NOT upload:
- `.env` (create this on server)
- `node_modules/`
- `.git/`
- `tests/`

## Step 3: Configure .htaccess

Create/Update `.htaccess` in your root directory (not public):

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

Create/Update `public/.htaccess`:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

## Step 4: Create .env File on Server

Create a `.env` file in your root directory with these settings:

```env
APP_NAME=ShopNow
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://yourdomain.infinityfreeapp.com

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=YOUR_INFINITYFREE_DB_HOST
DB_PORT=3306
DB_DATABASE=YOUR_INFINITYFREE_DB_NAME
DB_USERNAME=YOUR_INFINITYFREE_DB_USER
DB_PASSWORD=YOUR_INFINITYFREE_DB_PASSWORD

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

VITE_APP_NAME="${APP_NAME}"
```

## Step 5: Generate Application Key

Run this command locally to generate a key:
```bash
php artisan key:generate --show
```

Copy the generated key and paste it in your `.env` file on the server.

## Step 6: Set Up Database

1. Log in to InfinityFree control panel
2. Create a MySQL database
3. Note down:
   - Database name
   - Database username
   - Database password
   - Database host
4. Update your `.env` file with these credentials

## Step 7: Import Database

1. Export your local database:
   ```bash
   php artisan db:seed  # If you want sample data
   ```
   
2. Export using phpMyAdmin or command:
   ```bash
   mysqldump -u root shopnow > shopnow.sql
   ```

3. Import to InfinityFree:
   - Go to phpMyAdmin in InfinityFree control panel
   - Select your database
   - Click Import
   - Upload your SQL file

## Step 8: Set Permissions

Make sure these directories are writable (755 or 775):
```
/storage
/storage/app
/storage/app/public
/storage/framework
/storage/framework/cache
/storage/framework/sessions
/storage/framework/views
/storage/logs
/bootstrap/cache
```

## Step 9: Create Storage Link

Since you can't run artisan commands on InfinityFree, create a PHP file temporarily:

Create `create-storage-link.php` in your root:

```php
<?php
$target = __DIR__ . '/storage/app/public';
$link = __DIR__ . '/public/storage';

if (file_exists($link)) {
    echo "Storage link already exists!";
} else {
    symlink($target, $link);
    echo "Storage link created successfully!";
}
```

Visit: `https://yourdomain.infinityfreeapp.com/create-storage-link.php`

Then DELETE this file after running it!

## Step 10: Optimize for Production

Create `optimize.php` in your root:

```php
<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

// Clear and cache config
Artisan::call('config:cache');
echo "Config cached!\n";

// Clear and cache routes
Artisan::call('route:cache');
echo "Routes cached!\n";

// Clear and cache views
Artisan::call('view:cache');
echo "Views cached!\n";

echo "Optimization complete!";
```

Visit: `https://yourdomain.infinityfreeapp.com/optimize.php`

Then DELETE this file!

## Step 11: Security Checklist

- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Set `APP_ENV=production` in `.env`
- [ ] Delete `create-storage-link.php`
- [ ] Delete `optimize.php`
- [ ] Make sure `.env` is not publicly accessible
- [ ] Test all functionality

## Common Issues & Solutions

### Issue 1: 500 Internal Server Error
- Check `.htaccess` files are correct
- Check file permissions
- Check `.env` file exists and is configured
- Check error logs in control panel

### Issue 2: Assets Not Loading
- Make sure `npm run build` was run
- Check `public/build/` folder exists
- Verify `APP_URL` in `.env` is correct

### Issue 3: Database Connection Error
- Verify database credentials in `.env`
- Make sure database exists
- Check if database host is correct (usually not localhost on InfinityFree)

### Issue 4: Images Not Uploading
- Check storage permissions
- Verify storage link was created
- Check upload_max_filesize in PHP settings

## InfinityFree Limitations

⚠️ **Important Limitations:**
- No SSH access
- No command line access
- Limited PHP execution time (30 seconds)
- Limited file upload size (10MB)
- No cron jobs (use external services)
- Shared hosting resources

## Alternative: Better Hosting Options

For a production Laravel app, consider:
- **Heroku** (Free tier available)
- **Railway** (Free tier available)
- **Vercel** (For frontend)
- **PlanetScale** (Free MySQL database)
- **Cloudways** (Paid but affordable)
- **DigitalOcean** (Paid but full control)

## Support

If you encounter issues:
1. Check InfinityFree forums
2. Check Laravel documentation
3. Review error logs in control panel

---

**Note:** InfinityFree is great for learning but not recommended for production e-commerce sites due to limitations. Consider upgrading to paid hosting for better performance and features.
