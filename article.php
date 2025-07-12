<?php
// Include configuration
require_once 'config.php';

// Get article slug from URL
$slug = $_GET['slug'] ?? '';
$article = null;
$notFound = true;

// Find article by slug
if (!empty($slug) && !empty($articles)) {
    foreach ($articles as $id => $art) {
        if (isset($art['slug']) && $art['slug'] === $slug) {
            $article = $art;
            $notFound = false;
            break;
        }
    }
}

// If article not found, show 404
if ($notFound) {
    header("HTTP/1.0 404 Not Found");
    include('404.php');
    exit;
}

// Set article-specific SEO values
$pageTitle = $article['title'] . ' | ' . $seoTitle;
$pageDescription = $article['meta_description'] ?? $seoDescription;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Primary SEO Meta Tags -->
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($seoKeywords); ?>">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta property="og:image" content="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']; ?>/img-preview.jpg">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="twitter:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
    <meta property="twitter:description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <meta property="twitter:image" content="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']; ?>/img-preview.jpg">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']; ?>/article/<?php echo htmlspecialchars($slug); ?>">
    
    <!-- Stylesheets -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="js/app.js" defer></script>
    
    <?php if ($ezoicAdsEnabled && !empty($ezoicScript)): ?>
    <!-- Ezoic Ad Integration -->
    <?php echo $ezoicScript; ?>
    <?php endif; ?>
    
    <?php if ($googleAdsEnabled && !empty($googleAdsPublisherId)): ?>
    <!-- Google AdSense -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=<?php echo htmlspecialchars($googleAdsPublisherId); ?>" crossorigin="anonymous"></script>
    <?php endif; ?>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- JSON-LD structured data for SEO -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Article",
        "headline": "<?php echo htmlspecialchars($article['title']); ?>",
        "description": "<?php echo htmlspecialchars($pageDescription); ?>",
        "image": "<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']; ?>/img-preview.jpg",
        "datePublished": "<?php echo htmlspecialchars($article['date'] ?? date('Y-m-d')); ?>",
        "publisher": {
            "@type": "Organization",
            "name": "PinSave",
            "logo": {
                "@type": "ImageObject",
                "url": "<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']; ?>/img/logo.png"
            }
        },
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"
        }
    }
    </script>

    <div class="container mx-auto px-4 py-8">
        <header class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-600">PinSave - Pinterest Video Downloader</h1>
            <p class="text-gray-600">Download Pinterest Videos in HD Quality Without Watermark</p>
            <div class="mt-4">
                <a href="/" class="text-blue-500 hover:underline">
                    <i class="fas fa-home mr-1"></i> Home
                </a>
            </div>
        </header>
        
        <?php if ($googleAdsEnabled && !empty($googleAdsSlotTop)): ?>
        <!-- Google Ad - Top -->
        <div class="mb-6 text-center">
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="<?php echo htmlspecialchars($googleAdsPublisherId); ?>"
                 data-ad-slot="<?php echo htmlspecialchars($googleAdsSlotTop); ?>"
                 data-ad-format="auto"
                 data-full-width-responsive="true"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </div>
        <?php endif; ?>

        <!-- Article Content -->
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
            <article class="prose lg:prose-xl mx-auto">
                <h1 class="text-3xl font-bold mb-6"><?php echo htmlspecialchars($article['title']); ?></h1>
                
                <div class="text-sm text-gray-500 mb-6">
                    <span>Published: <?php echo htmlspecialchars($article['date'] ?? date('Y-m-d')); ?></span>
                </div>
                
                <?php if ($googleAdsEnabled && !empty($googleAdsSlotSidebar)): ?>
                <!-- Google Ad - In-article -->
                <div class="my-6 text-center">
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="<?php echo htmlspecialchars($googleAdsPublisherId); ?>"
                         data-ad-slot="<?php echo htmlspecialchars($googleAdsSlotSidebar); ?>"
                         data-ad-format="auto"
                         data-full-width-responsive="true"></ins>
                    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
                </div>
                <?php endif; ?>
                
                <div class="article-content">
                    <?php echo $article['content']; ?>
                </div>
            </article>
        </div>
        
        <?php if ($googleAdsEnabled && !empty($googleAdsSlotBottom)): ?>
        <!-- Google Ad - Bottom -->
        <div class="mt-8 mb-6 text-center">
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="<?php echo htmlspecialchars($googleAdsPublisherId); ?>"
                 data-ad-slot="<?php echo htmlspecialchars($googleAdsSlotBottom); ?>"
                 data-ad-format="auto"
                 data-full-width-responsive="true"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </div>
        <?php endif; ?>
        
        <div class="max-w-4xl mx-auto mt-8 p-6 bg-white rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Download Pinterest Videos Now</h2>
            <p class="mb-4">Want to download Pinterest videos? Use our free Pinterest video downloader tool.</p>
            <a href="/" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Go to Video Downloader
            </a>
        </div>
        
        <footer class="text-center mt-10 text-gray-500 text-sm">
            <p>&copy; <?php echo date('Y'); ?> PinSave - Pinterest Video Downloader | All Rights Reserved</p>
            <p class="mt-2">The fastest way to download and save Pinterest videos without watermark</p>
        </footer>
    </div>
</body>
</html>
