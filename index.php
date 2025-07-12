<?php
// Include configuration
require_once 'config.php';
require_once 'includes/stats_handler.php';

// Track visitor
$stats_handler = new StatsHandler();
$ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$country = null;

// Get country from IP (you can use a GeoIP service here)
if (isset($_SERVER['HTTP_CF_IPCOUNTRY'])) { // If using Cloudflare
    $country = $_SERVER['HTTP_CF_IPCOUNTRY'];
}

$stats_handler->logVisitor($ip, $user_agent, $country);

// Initialize variables
$videoUrl = "";
$error = "";
$debug = "";
$thumbnail = "";
$title = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['url'])) {
    $pinterestUrl = trim($_POST['url']);
    
    // Validate URL (basic check for Pinterest URL)
    if (strpos($pinterestUrl, 'pinterest.com') !== false || strpos($pinterestUrl, 'pin.it') !== false) {
        // API call function
        require_once 'api/pinterest_api_handler.php';
        $apiHandler = new PinSave\Api\PinterestApiHandler();
        $result = $apiHandler->getVideoData($pinterestUrl);
        
        if (isset($result['success']) && $result['success']) {
            $videoUrl = $result['video_url'];
            $thumbnail = $result['thumbnail'] ?? '';
            $title = $result['title'] ?? 'Pinterest Video';
        } else {
            $error = $result['message'] ?? "Failed to fetch video data. Please try again.";
            
            // Show debug info if available and debug mode is on
            if (defined('DEBUG_MODE') && DEBUG_MODE && isset($result['debug'])) {
                $debug = '<pre class="mt-4 p-4 bg-gray-900 text-green-400 text-sm overflow-auto max-h-48 rounded-xl border border-gray-700 font-mono">' . 
                         htmlspecialchars(print_r($result['debug'], true)) . 
                         '</pre>';
            }
        }
    } else {
        $error = "Please enter a valid Pinterest URL (pinterest.com or pin.it)";
    }
}

?>

<?php include 'header.php'; ?>

<main class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100">
    <!-- Hero Section with Modern Design -->
    <section class="relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 20% 50%, #E60023 0%, transparent 50%), radial-gradient(circle at 80% 50%, #FF4B2B 0%, transparent 50%);"></div>
        </div>
        
        <div class="relative gradient-primary text-white py-16 md:py-24 rounded-b-[3rem]">
            <div class="container mx-auto px-4">
                <div class="max-w-5xl mx-auto text-center">
                    <!-- Modern Hero Content -->
                    <div class="animate-slide-in">
                        <div class="flex justify-center mb-6">
                            <div class="icon-container bg-white/20 backdrop-blur-sm animate-pulse-slow">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                            </div>
                        </div>
                        <h1 class="hero-title text-4xl md:text-5xl lg:text-6xl font-bold mb-4">
                            Pinterest Video & Image Downloader
                        </h1>
                        <p class="hero-subtitle text-lg md:text-xl text-white/90 mb-8">
                            Download Pinterest videos and images in HD quality for free. No watermark, no registration, no app needed.
                        </p>
                    </div>
                    
                    <!-- Modern Download Form -->
                    <div class="animate-fade-in">
                        <div class="glass-card rounded-3xl p-8 max-w-4xl mx-auto shadow-2xl">
                            <form method="POST" action="" class="space-y-6" id="downloadForm">
                                <div class="flex flex-col lg:flex-row gap-4">
                                    <div class="flex-1 relative">
                                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"/>
                                            </svg>
                                        </div>
                                        <input type="url" 
                                               name="url" 
                                               placeholder="🔗 Paste your Pinterest video URL here (pinterest.com or pin.it)" 
                                               class="modern-input w-full pl-12 pr-4 text-gray-700"
                                               required>
                                    </div>
                                    <button type="submit" 
                                            class="btn-primary px-8 py-4 flex items-center justify-center gap-2 text-lg font-semibold min-w-[200px]"
                                            id="downloadBtn">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                                        </svg>
                                        Download Now
                                    </button>
                                </div>
                                
                                <!-- Enhanced Error Display -->
                                <?php if ($error): ?>
                                <div class="animate-slide-in">
                                    <div class="bg-red-50 border-l-4 border-red-400 p-6 rounded-xl">
                                        <div class="flex items-start">
                                            <svg class="w-6 h-6 text-red-400 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                            </svg>
                                            <div class="flex-1">
                                                <h3 class="text-red-800 font-semibold mb-2">🚨 Oops! Something went wrong</h3>
                                                <p class="text-red-700 mb-4"><?php echo htmlspecialchars($error); ?></p>
                                                <div class="bg-red-100 p-4 rounded-lg">
                                                    <h4 class="font-semibold text-red-800 mb-2">💡 Quick fixes:</h4>
                                                    <ul class="text-sm text-red-700 space-y-1">
                                                        <li>✅ Ensure the URL contains a video (not just an image)</li>
                                                        <li>✅ Use the full Pinterest URL (https://www.pinterest.com/pin/...)</li>
                                                        <li>✅ Make sure the post is public and accessible</li>
                                                        <li>✅ Copy the URL directly from your browser</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <!-- Debug Info -->
                                <?php if ($debug): ?>
                                <div class="animate-slide-in">
                                    <details class="group">
                                        <summary class="cursor-pointer text-gray-600 hover:text-gray-800 font-medium">
                                            🔧 Debug Information (Click to expand)
                                        </summary>
                                        <div class="mt-3">
                                            <?php echo $debug; ?>
                                        </div>
                                    </details>
                                </div>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Google Ads Section -->
    <?php if ($googleAdsEnabled && !empty($googleAdsSlotSidebar)): ?>
    <div class="container mx-auto px-4 py-8">
        <div class="modern-card p-6 text-center">
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="<?php echo htmlspecialchars($googleAdsPublisherId); ?>"
                 data-ad-slot="<?php echo htmlspecialchars($googleAdsSlotSidebar); ?>"
                 data-ad-format="auto"
                 data-full-width-responsive="true"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </div>
    </div>
    <?php endif; ?>
            
    <!-- Enhanced Video Preview Section -->
    <?php if ($videoUrl): ?>
    <section class="container mx-auto px-4 py-12">
        <div class="max-w-6xl mx-auto">
            <div class="modern-card p-8 animate-slide-in">
                <div class="flex items-center justify-center mb-8">
                    <div class="icon-container mr-4">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800">🎬 Video Preview</h2>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Video Preview -->
                    <div class="space-y-4">
                        <?php if (!empty($thumbnail)): ?>
                        <div class="relative group cursor-pointer rounded-2xl overflow-hidden">
                            <img src="<?php echo htmlspecialchars($thumbnail); ?>" 
                                 alt="Video Thumbnail" 
                                 class="w-full h-auto rounded-2xl transition-transform duration-300 group-hover:scale-105">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                                <div class="bg-white/20 backdrop-blur-sm rounded-full p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="bg-gray-900 rounded-2xl overflow-hidden shadow-2xl">
                            <video controls class="w-full h-auto">
                                <source src="<?php echo htmlspecialchars($videoUrl); ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                    
                    <!-- Download Options -->
                    <div class="flex flex-col justify-center space-y-6">
                        <?php if (!empty($title)): ?>
                        <div class="bg-gray-50 p-6 rounded-2xl">
                            <div class="flex items-start gap-3">
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-gray-800 mb-2">📝 Video Title</h3>
                                    <p class="text-gray-600 leading-relaxed"><?php echo htmlspecialchars($title); ?></p>
                                </div>
                                <button 
                                    onclick="copyToClipboard('<?php echo htmlspecialchars(addslashes($title)); ?>')"
                                    class="p-3 bg-white rounded-xl hover:bg-gray-100 transition-colors duration-200 group"
                                    title="Copy title">
                                    <svg class="w-5 h-5 text-gray-500 group-hover:text-[#E60023]" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Download Buttons -->
                        <div class="space-y-4">
                            <a href="<?php echo htmlspecialchars($videoUrl); ?>" 
                               download="<?php echo htmlspecialchars($title); ?>.mp4"
                               class="btn-primary w-full py-4 px-6 rounded-2xl flex items-center justify-center gap-3 text-lg font-semibold group">
                                <svg class="w-6 h-6 group-hover:animate-bounce" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                                </svg>
                                Download HD Video
                            </a>
                            
                            <button onclick="copyToClipboard('<?php echo htmlspecialchars(addslashes($videoUrl)); ?>')"
                                    class="btn-secondary w-full py-4 px-6 rounded-2xl flex items-center justify-center gap-3 text-lg font-semibold group">
                                <svg class="w-6 h-6 group-hover:animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"/>
                                </svg>
                                Copy Video Link
                            </button>
                        </div>
                        
                        <!-- Helper Text -->
                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-200">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                <p class="text-blue-700 text-sm">
                                    💡 <strong>Pro tip:</strong> If the download button doesn't work, right-click on the video and select "Save video as..."
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Enhanced How-to-Use Section -->
    <section class="py-16 bg-gradient-to-r from-gray-50 to-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">🚀 How to Use</h2>
                <p class="text-xl text-gray-600">Download Pinterest videos in 3 simple steps</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Step 1 -->
                <div class="modern-card p-8 text-center group">
                    <div class="icon-container mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">1. Copy URL</h3>
                    <p class="text-gray-600">Find your Pinterest video and copy the URL from your browser's address bar</p>
                </div>
                
                <!-- Step 2 -->
                <div class="modern-card p-8 text-center group">
                    <div class="icon-container mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 2h-4.18C14.4.84 13.3 0 12 0c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm7 18H5V4h2v3h10V4h2v16z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">2. Paste URL</h3>
                    <p class="text-gray-600">Paste the Pinterest URL into our download form and click the download button</p>
                </div>
                
                <!-- Step 3 -->
                <div class="modern-card p-8 text-center group">
                    <div class="icon-container mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">3. Download</h3>
                    <p class="text-gray-600">Preview your video and download it in high quality to your device</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Features Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">✨ Why Choose PinSave?</h2>
                <p class="text-xl text-gray-600">The most advanced Pinterest video downloader</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Feature 1 -->
                <div class="modern-card p-8 text-center group">
                    <div class="icon-container mx-auto mb-6 bg-gradient-to-r from-yellow-400 to-orange-500 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M13 2.05v3.03c3.39.49 6 3.39 6 6.92 0 .9-.18 1.75-.48 2.54l2.6 1.53c.56-1.24.88-2.62.88-4.07 0-5.18-3.95-9.45-9-9.95zM12 19c-3.87 0-7-3.13-7-7 0-3.53 2.61-6.43 6-6.92V2.05c-5.06.5-9 4.76-9 9.95 0 5.52 4.47 10 9.99 10 3.31 0 6.24-1.61 8.06-4.09l-2.6-1.53C16.17 17.98 14.21 19 12 19z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">⚡ Lightning Fast</h3>
                    <p class="text-gray-600">Download videos instantly with our optimized servers. No waiting, no delays!</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="modern-card p-8 text-center group">
                    <div class="icon-container mx-auto mb-6 bg-gradient-to-r from-green-400 to-blue-500 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1M10,17L6,13L7.41,11.59L10,14.17L16.59,7.58L18,9L10,17Z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">🔒 100% Safe</h3>
                    <p class="text-gray-600">No registration required. Your privacy is protected with SSL encryption.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="modern-card p-8 text-center group">
                    <div class="icon-container mx-auto mb-6 bg-gradient-to-r from-purple-400 to-pink-500 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17,10.5V7A1,1 0 0,0 16,6H4A1,1 0 0,0 3,7V17A1,1 0 0,0 4,18H16A1,1 0 0,0 17,17V13.5L21,17.5V6.5L17,10.5Z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">🎯 HD Quality</h3>
                    <p class="text-gray-600">Download videos in the highest quality available. Crystal clear, no watermarks.</p>
                </div>
                
                <!-- Feature 4 -->
                <div class="modern-card p-8 text-center group">
                    <div class="icon-container mx-auto mb-6 bg-gradient-to-r from-indigo-400 to-purple-500 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17,19H7V5H17M17,1H7C5.89,1 5,1.89 5,3V21C5,22.11 5.89,23 7,23H17C18.11,23 19,22.11 19,21V3C19,1.89 18.11,1 17,1Z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">📱 Mobile Friendly</h3>
                    <p class="text-gray-600">Works perfectly on all devices - phone, tablet, or desktop. Download anywhere!</p>
                </div>
                
                <!-- Feature 5 -->
                <div class="modern-card p-8 text-center group">
                    <div class="icon-container mx-auto mb-6 bg-gradient-to-r from-red-400 to-pink-500 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4M12,6A6,6 0 0,0 6,12A6,6 0 0,0 12,18A6,6 0 0,0 18,12A6,6 0 0,0 12,6M12,8A4,4 0 0,1 16,12A4,4 0 0,1 12,16A4,4 0 0,1 8,12A4,4 0 0,1 12,8Z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">🎯 All Formats</h3>
                    <p class="text-gray-600">Support for all Pinterest video types - regular pins, idea pins, and story pins.</p>
                </div>
                
                <!-- Feature 6 -->
                <div class="modern-card p-8 text-center group">
                    <div class="icon-container mx-auto mb-6 bg-gradient-to-r from-teal-400 to-green-500 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4M11,16.5L6.5,12L7.91,10.59L11,13.67L16.59,8.09L18,9.5L11,16.5Z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">💯 Free Forever</h3>
                    <p class="text-gray-600">Always free to use with no limits. No hidden fees or premium accounts required.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced FAQ Section -->
    <section class="py-16 bg-gradient-to-br from-gray-50 to-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">❓ Frequently Asked Questions</h2>
                <p class="text-xl text-gray-600">Everything you need to know about downloading Pinterest videos</p>
            </div>
            
            <div class="max-w-4xl mx-auto space-y-6" itemscope itemtype="https://schema.org/FAQPage">
                <!-- FAQ Item 1 -->
                <div class="modern-card p-6 group" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-[#E60023] to-[#FF4B2B] rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-sm">Q</span>
                        </div>
                        <div class="flex-1">
                            <h3 itemprop="name" class="text-xl font-bold text-gray-800 mb-3">Is it completely free to download Pinterest videos?</h3>
                            <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                                <div itemprop="text" class="text-gray-600">
                                    <p>Yes! PinSave is 100% free to use with no hidden costs, registration requirements, or download limits. You can download as many Pinterest videos as you want without paying anything.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- FAQ Item 2 -->
                <div class="modern-card p-6 group" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-[#E60023] to-[#FF4B2B] rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-sm">Q</span>
                        </div>
                        <div class="flex-1">
                            <h3 itemprop="name" class="text-xl font-bold text-gray-800 mb-3">What video quality can I download?</h3>
                            <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                                <div itemprop="text" class="text-gray-600">
                                    <p>We provide the highest quality available from Pinterest, typically HD quality (720p or 1080p). The quality depends on the original video uploaded to Pinterest.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- FAQ Item 3 -->
                <div class="modern-card p-6 group" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-[#E60023] to-[#FF4B2B] rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-sm">Q</span>
                        </div>
                        <div class="flex-1">
                            <h3 itemprop="name" class="text-xl font-bold text-gray-800 mb-3">Do I need to install any software?</h3>
                            <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                                <div itemprop="text" class="text-gray-600">
                                    <p>No installation required! PinSave is a web-based tool that works directly in your browser. Just paste the URL and download - it's that simple.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- FAQ Item 4 -->
                <div class="modern-card p-6 group" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-[#E60023] to-[#FF4B2B] rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-sm">Q</span>
                        </div>
                        <div class="flex-1">
                            <h3 itemprop="name" class="text-xl font-bold text-gray-800 mb-3">Are there any watermarks on downloaded videos?</h3>
                            <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                                <div itemprop="text" class="text-gray-600">
                                    <p>No, we don't add any watermarks to your downloads. You get the original video file exactly as it appears on Pinterest, clean and watermark-free.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- FAQ Item 5 -->
                <div class="modern-card p-6 group" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-[#E60023] to-[#FF4B2B] rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-sm">Q</span>
                        </div>
                        <div class="flex-1">
                            <h3 itemprop="name" class="text-xl font-bold text-gray-800 mb-3">Does it work on mobile devices?</h3>
                            <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                                <div itemprop="text" class="text-gray-600">
                                    <p>Absolutely! PinSave works perfectly on all devices - smartphones, tablets, and desktops. The interface is fully responsive and optimized for mobile use.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced SEO Content Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto modern-card p-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">📚 Complete Guide to Pinterest Video Downloading</h2>
                    <p class="text-gray-600">Learn everything about downloading Pinterest videos safely and legally</p>
                </div>
                
                <div class="prose max-w-none text-gray-700 space-y-6">
                    <div class="bg-gradient-to-r from-[#E60023]/10 to-[#FF4B2B]/10 p-6 rounded-2xl border-l-4 border-[#E60023]">
                        <p class="text-lg leading-relaxed">
                            <strong>PinSave</strong> is the most advanced and user-friendly Pinterest video downloader available today. Our tool supports all types of Pinterest videos including regular Pins, Idea Pins, and Story Pins. Whether you're using a shortened pin.it URL or a full pinterest.com link, our downloader handles it all with ease.
                        </p>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-6 rounded-2xl">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">🎯 Step-by-Step Process</h3>
                            <ol class="list-decimal pl-5 space-y-2 text-gray-600">
                                <li><strong>Find your video</strong> - Browse Pinterest and find the video you want to download</li>
                                <li><strong>Copy the URL</strong> - Copy the Pinterest video URL from your browser's address bar</li>
                                <li><strong>Paste and download</strong> - Paste the URL into our tool and click download</li>
                                <li><strong>Save to device</strong> - Preview and save the video to your device in HD quality</li>
                            </ol>
                        </div>
                        
                        <div class="bg-gray-50 p-6 rounded-2xl">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">✅ Supported Features</h3>
                            <ul class="list-disc pl-5 space-y-2 text-gray-600">
                                <li>All Pinterest video formats</li>
                                <li>HD quality downloads (720p/1080p)</li>
                                <li>No watermarks or branding</li>
                                <li>Mobile and desktop compatibility</li>
                                <li>Fast processing speeds</li>
                                <li>No registration required</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="bg-blue-50 p-6 rounded-2xl border border-blue-200">
                        <h3 class="text-xl font-bold text-blue-800 mb-3">🛡️ Safety and Legal Considerations</h3>
                        <p class="text-blue-700">
                            When downloading Pinterest videos, always respect copyright laws and the original creator's rights. Only download videos for personal use or when you have permission from the content owner. PinSave is a tool designed to help users save videos for offline viewing and personal reference.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Enhanced JavaScript -->
<script>
// Copy to clipboard function with modern UI feedback
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Create and show toast notification
        showToast('✅ Copied to clipboard!', 'success');
    }, function(err) {
        console.error('Could not copy text: ', err);
        showToast('❌ Failed to copy', 'error');
    });
}

// Modern toast notification system
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-lg transform transition-all duration-300 ease-in-out ${
        type === 'success' 
            ? 'bg-green-500 text-white' 
            : 'bg-red-500 text-white'
    }`;
    toast.innerHTML = `
        <div class="flex items-center gap-2">
            <span class="font-semibold">${message}</span>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Animate in
    setTimeout(() => {
        toast.style.transform = 'translateX(0)';
        toast.style.opacity = '1';
    }, 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        toast.style.transform = 'translateX(100%)';
        toast.style.opacity = '0';
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 300);
    }, 3000);
}

// Enhanced form submission with loading state
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('downloadForm');
    const submitBtn = document.getElementById('downloadBtn');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <div class="loading-spinner"></div>
                Processing...
            `;
            
            // Add loading class to form
            form.classList.add('opacity-75');
        });
    }
    
    // Add smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Add intersection observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
            }
        });
    }, observerOptions);
    
    // Observe all cards and sections
    document.querySelectorAll('.modern-card, section').forEach(el => {
        observer.observe(el);
    });
});

// Enhanced video preview functionality
document.addEventListener('DOMContentLoaded', function() {
    const video = document.querySelector('video');
    if (video) {
        video.addEventListener('loadedmetadata', function() {
            // Add video duration to UI
            const duration = Math.floor(video.duration);
            const minutes = Math.floor(duration / 60);
            const seconds = duration % 60;
            
            const durationElement = document.createElement('span');
            durationElement.className = 'text-sm text-gray-500';
            durationElement.textContent = `Duration: ${minutes}:${seconds.toString().padStart(2, '0')}`;
            
            const videoContainer = video.closest('.space-y-4');
            if (videoContainer) {
                videoContainer.appendChild(durationElement);
            }
        });
    }
});
</script>

<?php include 'footer.php'; ?>