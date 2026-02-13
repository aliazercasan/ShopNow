<?php
/**
 * Storage Setup Script for InfinityFree
 * Run this once after uploading to create necessary directories
 * Visit: https://shopnow.kesug.com/setup-storage.php
 */

$directories = [
    'storage/products',
    'storage/business_permits',
];

$results = [];

foreach ($directories as $dir) {
    $path = __DIR__ . '/public/' . $dir;
    
    if (!file_exists($path)) {
        if (mkdir($path, 0755, true)) {
            $results[] = "✓ Created: public/{$dir}";
        } else {
            $results[] = "✗ Failed to create: public/{$dir}";
        }
    } else {
        $results[] = "✓ Already exists: public/{$dir}";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Storage Setup - ShopNow</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #2563eb; margin-top: 0; }
        .result { padding: 10px; margin: 10px 0; border-radius: 4px; font-family: monospace; }
        .success { background: #d1fae5; color: #065f46; }
        .error { background: #fee2e2; color: #991b1b; }
        .info { background: #dbeafe; color: #1e40af; padding: 15px; border-radius: 4px; margin-top: 20px; }
        .btn { display: inline-block; padding: 10px 20px; background: #2563eb; color: white; text-decoration: none; border-radius: 4px; margin-top: 20px; }
        .btn:hover { background: #1d4ed8; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📁 Storage Setup Complete</h1>
        
        <?php foreach ($results as $result): ?>
            <div class="result <?php echo strpos($result, '✓') !== false ? 'success' : 'error'; ?>">
                <?php echo $result; ?>
            </div>
        <?php endforeach; ?>
        
        <div class="info">
            <strong>✓ Setup Complete!</strong><br>
            Your storage directories are now ready. You can now upload products with images.
            <br><br>
            <strong>Important:</strong> Delete this file (setup-storage.php) after setup for security.
        </div>
        
        <a href="/" class="btn">Go to Homepage</a>
    </div>
</body>
</html>
