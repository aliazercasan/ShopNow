<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Expired - ShopNow</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen flex items-center justify-center px-4">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
            <!-- Icon -->
            <div class="inline-flex items-center justify-center w-20 h-20 bg-amber-100 rounded-full mb-6">
                <svg class="w-10 h-10 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            
            <!-- Title -->
            <h1 class="text-3xl font-bold text-gray-900 mb-3">Page Expired</h1>
            
            <!-- Message -->
            <p class="text-gray-600 mb-6">
                Your session has expired due to inactivity. This happens for security reasons.
            </p>
            
            <!-- Info Box -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 text-left">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-blue-900">Why did this happen?</p>
                        <p class="text-xs text-blue-700 mt-1">
                            You left the page open for too long, or your browser cleared the session data.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="space-y-3">
                <button onclick="window.history.back(); setTimeout(() => location.reload(), 100);" 
                    class="w-full bg-gradient-to-r from-primary-600 to-primary-700 text-white py-3 rounded-lg hover:from-primary-700 hover:to-primary-800 transition shadow-md hover:shadow-lg font-semibold flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span>Go Back & Refresh</span>
                </button>
                
                <a href="{{ route('products.index') }}" 
                    class="block w-full bg-gray-100 text-gray-700 py-3 rounded-lg hover:bg-gray-200 transition font-medium">
                    Go to Homepage
                </a>
            </div>
            
            <!-- Tip -->
            <div class="mt-6 pt-6 border-t border-gray-100">
                <p class="text-xs text-gray-500">
                    💡 Tip: Complete forms quickly to avoid session expiration
                </p>
            </div>
        </div>
    </div>
    
    <style>
        .primary-600 { background-color: #2563eb; }
        .primary-700 { background-color: #1d4ed8; }
        .primary-800 { background-color: #1e40af; }
    </style>
</body>
</html>
