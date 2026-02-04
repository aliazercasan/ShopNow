@echo off
echo ========================================
echo ShopNow Build Files Verification
echo ========================================
echo.

echo Checking if build files exist...
echo.

if exist "public\build\manifest.json" (
    echo [OK] manifest.json found
) else (
    echo [MISSING] manifest.json NOT found
    echo Run: npm run build
)

if exist "public\build\assets\app-C0m77Fv3.css" (
    echo [OK] CSS file found
) else (
    echo [MISSING] CSS file NOT found
    echo Run: npm run build
)

if exist "public\build\assets\app-CWxCsbqF.js" (
    echo [OK] JS file found
) else (
    echo [MISSING] JS file NOT found
    echo Run: npm run build
)

echo.
echo ========================================
echo Files to upload to InfinityFree:
echo ========================================
echo.
echo 1. public\build\manifest.json
echo 2. public\build\assets\app-C0m77Fv3.css
echo 3. public\build\assets\app-CWxCsbqF.js
echo.
echo Upload these to:
echo htdocs/public/build/ (on your server)
echo.
echo ========================================
echo.
pause
