<?php
// Include configuration
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Page Not Found | PinSave</title>
    <meta name="description" content="The page you are looking for could not be found.">
    <meta name="robots" content="noindex, nofollow">
    
    <!-- Stylesheets -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-16">
        <header class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-600">PinSave - Pinterest Video Downloader</h1>
            <p class="text-gray-600">Download Pinterest Videos in HD Quality Without Watermark</p>
        </header>
        
        <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md p-8 text-center">
            <div class="text-6xl text-red-500 mb-6">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <h2 class="text-3xl font-bold mb-4">404 - Page Not Found</h2>
            <p class="text-gray-600 mb-6">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
            
            <a href="/" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg">
                <i class="fas fa-home mr-2"></i> Go to Homepage
            </a>
        </div>
        
        <footer class="text-center mt-10 text-gray-500 text-sm">
            <p>&copy; <?php echo date('Y'); ?> PinSave - Pinterest Video Downloader | All Rights Reserved</p>
        </footer>
    </div>
</body>
</html>
