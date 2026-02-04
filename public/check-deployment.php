<?php
/**
 * Deployment Checker for InfinityFree
 * Upload this file to public/ folder and visit it to check your deployment
 * URL: https://shopnow.kesug.com/check-deployment.php
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>ShopNow Deployment Checker</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
        .check { background: white; padding: 20px; margin: 10px 0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .success { border-left: 4px solid #10b981; }
        .error { border-left: 4px solid #ef4444; }
        .warning { border-left: 4px solid #f59e0b; }
        h1 { color: #1f2937; }
        h2 { color: #374151; font-size: 18px; margin: 0 0 10px 0; }
        p { margin: 5px 0; color: #6b7280; }
        .status { font-weight: bold; }
        .success .status { color: #10b981; }
        .error .status { color: #ef4444; }
        .warning .status { color: #f59e0b; }
        code { background: #f3f4f6; padding: 2px 6px; border-radius: 3px; font-size: 12px; }
    </style>
</head>
<body>
    <h1>🔍 ShopNow Deployment Checker</h1>
    <p style="margin-bottom: 30px;">This page checks if your Laravel application is properly deployed on InfinityFree.</p>

    <?php
    // Check 1: PHP Version
    $phpVersion = phpversion();
    $phpOk = version_compare($phpVersion, '8.1.0', '>=');
    ?>
    <div class="check <?php echo $phpOk ? 'success' : 'error'; ?>">
        <h2>PHP Version</h2>
        <p class="status"><?php echo $phpOk ? '✓ PASS' : '✗ FAIL'; ?></p>
        <p>Current: <code><?php echo $phpVersion; ?></code></p>
        <p>Required: <code>8.1.0 or higher</code></p>
    </div>

    <?php
    // Check 2: Build Files
    $manifestExists = file_exists(__DIR__ . '/build/manifest.json');
    $cssExists = file_exists(__DIR__ . '/build/assets/app-C0m77Fv3.css');
    $jsExists = file_exists(__DIR__ . '/build/assets/app-CWxCsbqF.js');
    $buildOk = $manifestExists && $cssExists && $jsExists;
    ?>
    <div class="check <?php echo $buildOk ? 'success' : 'error'; ?>">
        <h2>Build Files (CSS/JS)</h2>
        <p class="status"><?php echo $buildOk ? '✓ PASS' : '✗ FAIL'; ?></p>
        <p>Manifest: <?php echo $manifestExists ? '✓ Found' : '✗ Missing'; ?> <code>public/build/manifest.json</code></p>
        <p>CSS: <?php echo $cssExists ? '✓ Found' : '✗ Missing'; ?> <code>public/build/assets/app-C0m77Fv3.css</code></p>
        <p>JS: <?php echo $jsExists ? '✓ Found' : '✗ Missing'; ?> <code>public/build/assets/app-CWxCsbqF.js</code></p>
        <?php if (!$buildOk): ?>
        <p style="color: #ef4444; margin-top: 10px;"><strong>⚠️ This is why your CSS/JS is not loading!</strong></p>
        <p>Upload the <code>public/build/</code> folder from your local project.</p>
        <?php endif; ?>
    </div>

    <?php
    // Check 3: .env file
    $envExists = file_exists(__DIR__ . '/../.env');
    ?>
    <div class="check <?php echo $envExists ? 'success' : 'error'; ?>">
        <h2>.env Configuration File</h2>
        <p class="status"><?php echo $envExists ? '✓ PASS' : '✗ FAIL'; ?></p>
        <p><?php echo $envExists ? 'File exists' : 'File missing'; ?></p>
        <?php if (!$envExists): ?>
        <p style="color: #ef4444;">Upload <code>.env.production</code> as <code>.env</code> to your server root.</p>
        <?php endif; ?>
    </div>

    <?php
    // Check 4: Storage folder permissions
    $storagePath = __DIR__ . '/../storage';
    $storageWritable = is_writable($storagePath);
    ?>
    <div class="check <?php echo $storageWritable ? 'success' : 'warning'; ?>">
        <h2>Storage Folder Permissions</h2>
        <p class="status"><?php echo $storageWritable ? '✓ PASS' : '⚠ WARNING'; ?></p>
        <p><?php echo $storageWritable ? 'Writable' : 'Not writable'; ?></p>
        <?php if (!$storageWritable): ?>
        <p style="color: #f59e0b;">Set <code>storage/</code> folder permissions to 755.</p>
        <?php endif; ?>
    </div>

    <?php
    // Check 5: .htaccess files
    $rootHtaccess = file_exists(__DIR__ . '/../.htaccess');
    $publicHtaccess = file_exists(__DIR__ . '/.htaccess');
    $htaccessOk = $rootHtaccess && $publicHtaccess;
    ?>
    <div class="check <?php echo $htaccessOk ? 'success' : 'warning'; ?>">
        <h2>.htaccess Files</h2>
        <p class="status"><?php echo $htaccessOk ? '✓ PASS' : '⚠ WARNING'; ?></p>
        <p>Root: <?php echo $rootHtaccess ? '✓ Found' : '✗ Missing'; ?> <code>.htaccess</code></p>
        <p>Public: <?php echo $publicHtaccess ? '✓ Found' : '✗ Missing'; ?> <code>public/.htaccess</code></p>
    </div>

    <?php
    // Check 6: Vendor folder
    $vendorExists = file_exists(__DIR__ . '/../vendor/autoload.php');
    ?>
    <div class="check <?php echo $vendorExists ? 'success' : 'error'; ?>">
        <h2>Composer Dependencies</h2>
        <p class="status"><?php echo $vendorExists ? '✓ PASS' : '✗ FAIL'; ?></p>
        <p><?php echo $vendorExists ? 'Vendor folder exists' : 'Vendor folder missing'; ?></p>
        <?php if (!$vendorExists): ?>
        <p style="color: #ef4444;">Upload the <code>vendor/</code> folder or run <code>composer install</code>.</p>
        <?php endif; ?>
    </div>

    <?php
    // Summary
    $allChecks = [$phpOk, $buildOk, $envExists, $storageWritable, $htaccessOk, $vendorExists];
    $passedChecks = count(array_filter($allChecks));
    $totalChecks = count($allChecks);
    ?>
    <div class="check <?php echo $passedChecks === $totalChecks ? 'success' : 'warning'; ?>" style="margin-top: 30px;">
        <h2>Summary</h2>
        <p class="status"><?php echo $passedChecks; ?> / <?php echo $totalChecks; ?> checks passed</p>
        <?php if ($passedChecks === $totalChecks): ?>
        <p style="color: #10b981;">✓ Your deployment looks good! If you still have issues, visit <code>/clear-all-cache</code></p>
        <?php else: ?>
        <p style="color: #f59e0b;">⚠️ Please fix the issues above and refresh this page.</p>
        <?php endif; ?>
    </div>

    <div style="margin-top: 30px; padding: 20px; background: white; border-radius: 8px;">
        <h2>Next Steps</h2>
        <ol style="color: #6b7280; line-height: 1.8;">
            <li>Fix any failed checks above</li>
            <li>Visit <a href="/clear-all-cache" style="color: #2563eb;">/clear-all-cache</a> to clear Laravel caches</li>
            <li>Visit <a href="/" style="color: #2563eb;">your homepage</a> to test the site</li>
            <li>Delete this file (<code>check-deployment.php</code>) after deployment is complete</li>
        </ol>
    </div>

    <p style="text-align: center; color: #9ca3af; margin-top: 30px; font-size: 12px;">
        ShopNow Deployment Checker | Delete this file after successful deployment
    </p>
</body>
</html>
