<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/schema_generator.php';
require_once __DIR__ . '/includes/seo_analytics.php';

// Initialize SEO Analytics
$seoAnalytics = new SeoAnalytics();

// Get language from URL or default to English
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';

// Multilingual SEO content
$seoContent = [
    'en' => [
        'title' => 'Pinterest Video Downloader | Download Pinterest Videos in HD Free',
        'description' => 'Use our free Pinterest Downloader to save videos and images online in HD. Fast, easy, and secure Pinterest video download tool. No app needed.',
        'keywords' => 'pinterest downloader, pinterest video downloader, pinterest video download, download video pinterest, pinterest com download, pinterest video downloader app, download video from pinterest, pinterest download video, download pinterest images, pinterest photo download, download pinterest video, pinterest downloader apk, pinterest video downloader apk, download video from pinterest link, pin downloader, download pinterest videos, pinterest download hd, pinterest downloader for iphone, download pinterest videos in usa, pinterest video download HD no login, pinterest downloader for school projects, best pinterest downloader 2025 USA, pinterest downloader video, best pinterest video downloader, pinterest video download full hd 1080p, instagram downloader, pinterest video download hd, pinterest video download status, pinterest video downloader chrome, pinterest video, convert pinterest video to mp4, pinterest videos saver in mobile, pinterest videos saver in chrome, pinterest videos saver extension, pinterest video to gif, pinterest video downloader iphone'
    ],
    'hi' => [
        'title' => 'Pinterest वीडियो डाउनलोड करें | HD में Pinterest वीडियो सेव करें',
        'description' => 'पिंटरेस्ट वीडियो और पिन्स को HD क्वालिटी में फ्री में डाउनलोड करें। तेज़, सुरक्षित और आसान पिंटरेस्ट डाउनलोडर टूल।',
        'keywords' => 'पिंटरेस्ट डाउनलोडर, पिंटरेस्ट वीडियो डाउनलोडर, पिन डाउनलोडर, पिंटरेस्ट वीडियो कैसे डाउनलोड करें, पिंटरेस्ट एचडी डाउनलोड, वीडियो डाउनलोडर, यूट्यूब वीडियो डाउनलोड, ऑनलाइन वीडियो डाउनलोडर, फेसबुक वीडियो डाउनलोड, बेस्ट वीडियो डाउनलोडर'
    ],
    'es' => [
        'title' => 'Descargar videos de Pinterest | Descargar en HD Gratis',
        'description' => 'Usa nuestra herramienta gratuita para descargar videos de Pinterest en HD. Rápido, seguro y sin necesidad de registrarse.',
        'keywords' => 'descargador de pinterest, descargador de videos de pinterest, descargador de pines, descargar videos de pinterest, descarga de pinterest hd, cómo descargar videos de pinterest, descargador de videos, descarga de videos de youtube, descargador de videos en línea, descarga de videos de facebook, mejor descargador de videos'
    ],
    'fr' => [
        'title' => 'Télécharger des vidéos Pinterest | Téléchargement HD Gratuit',
        'description' => 'Utilisez notre téléchargeur Pinterest gratuit pour enregistrer des vidéos en haute qualité. Rapide, sécurisé et sans inscription.',
        'keywords' => 'téléchargeur pinterest, téléchargeur de vidéos pinterest, téléchargeur de pin, télécharger des vidéos pinterest, téléchargement pinterest hd, comment télécharger des vidéos pinterest, téléchargeur de vidéos, téléchargement de vidéos youtube, téléchargeur de vidéos en ligne, téléchargement de vidéos facebook, meilleur téléchargeur de vidéos'
    ],
    'de' => [
        'title' => 'Pinterest-Videos herunterladen | Kostenlos in HD speichern',
        'description' => 'Laden Sie Pinterest-Videos kostenlos in HD herunter. Einfacher, schneller und sicherer Pinterest-Downloader ohne Anmeldung.',
        'keywords' => 'pinterest downloader, pinterest video downloader, pin downloader, pinterest videos herunterladen, pinterest hd download, wie man pinterest videos herunterlädt, video downloader, youtube video herunterladen, online video downloader, facebook video herunterladen, bester video downloader'
    ],
    'pt' => [
        'title' => 'Baixar vídeos do Pinterest | Download HD Gratuito',
        'description' => 'Baixe vídeos do Pinterest em alta qualidade gratuitamente. Ferramenta online rápida e segura, sem necessidade de aplicativo.',
        'keywords' => 'baixador de pinterest, baixador de vídeo do pinterest, baixar pin, baixar vídeos do pinterest, download pinterest hd, como baixar vídeos do pinterest, baixador de vídeos, baixar vídeo do youtube, baixador de vídeos online, baixar vídeo do facebook, melhor baixador de vídeos'
    ],
    'it' => [
        'title' => 'Scarica Video da Pinterest | Download HD Gratis',
        'description' => 'Scarica video di Pinterest in HD gratuitamente. Downloader semplice, veloce e sicuro senza registrazione.',
        'keywords' => 'scaricatore pinterest, scaricatore video pinterest, scaricatore pin, scaricare video da pinterest, download pinterest hd, come scaricare video da pinterest, scaricatore video, scaricare video youtube, scaricatore video online, scaricare video facebook, miglior scaricatore video'
    ],
    'tr' => [
        'title' => 'Pinterest Video İndir | Ücretsiz HD Video İndirme',
        'description' => 'Pinterest videolarını HD kalitesinde ücretsiz indirin. Hızlı, güvenli ve kolay video indirme aracı.',
        'keywords' => 'pinterest indirici, pinterest video indirici, pin indirici, pinterest videoları indir, pinterest hd indir, pinterest videoları nasıl indirilir, video indirici, youtube video indir, çevrimiçi video indirici, facebook video indir, en iyi video indirici'
    ],
    'id' => [
        'title' => 'Unduh Video Pinterest | Downloader HD Gratis',
        'description' => 'Gunakan alat gratis kami untuk mengunduh video Pinterest dalam kualitas HD. Cepat, aman, dan mudah digunakan.',
        'keywords' => 'pengunduh pinterest, pengunduh video pinterest, pengunduh pin, cara mengunduh video pinterest, unduhan pinterest hd, video downloader, unduh video youtube, pengunduh video online, unduh video facebook, pengunduh video terbaik'
    ],
    'bn' => [
        'title' => 'Pinterest ভিডিও ডাউনলোড | HD তে ভিডিও সেভ করুন ফ্রিতে',
        'description' => 'Pinterest ভিডিও সহজেই HD কোয়ালিটিতে ডাউনলোড করুন। দ্রুত, নিরাপদ এবং ফ্রি টুল – কোনো অ্যাপের দরকার নেই।',
        'keywords' => 'পিন্টারেস্ট ডাউনলোডার, পিন্টারেস্ট ভিডিও ডাউনলোডার, পিন ডাউনলোডার, পিন্টারেস্ট ভিডিও কিভাবে ডাউনলোড করবেন, পিন্টারেস্ট এইচডি ডাউনলোড, ভিডিও ডাউনলোডার, ইউটিউব ভিডিও ডাউনলোড, অনলাইন ভিডিও ডাউনলোডার, ফেসবুক ভিডিও ডাউনলোড, সেরা ভিডিও ডাউনলোডার'
    ]
];

// Set SEO variables based on language
$seoTitle = $seoContent[$lang]['title'] ?? $seoContent['en']['title'];
$seoDescription = $seoContent[$lang]['description'] ?? $seoContent['en']['description'];
$seoKeywords = $seoContent[$lang]['keywords'] ?? $seoContent['en']['keywords'];
?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($lang); ?>">
<head>
    <meta charset="UTF-8">
    
    <!-- Primary SEO Meta Tags -->
    <title><?php echo htmlspecialchars($seoTitle); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($seoDescription); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($seoKeywords); ?>">
    
    <!-- Google Search Console Verification -->
    <?php 
    // Add verification tag if configured in admin settings
    if (isset($adminConfig['seo']['google_verification'])) {
        echo '<meta name="google-site-verification" content="' . htmlspecialchars($adminConfig['seo']['google_verification']) . '" />';
    }
    ?>
    
    <!-- Core Web Vitals & Mobile Optimization -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="preconnect" href="https://cdn.tailwindcss.com">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    
    <!-- hreflang tags for language variants -->
    <!-- Hreflang Tags -->
    <link rel="alternate" hreflang="en" href="https://pinsave.in/en/" />
    <link rel="alternate" hreflang="hi" href="https://pinsave.in/hi/" />
    <link rel="alternate" hreflang="es" href="https://pinsave.in/es/" />
    <link rel="alternate" hreflang="fr" href="https://pinsave.in/fr/" />
    <link rel="alternate" hreflang="de" href="https://pinsave.in/de/" />
    <link rel="alternate" hreflang="pt" href="https://pinsave.in/pt/" />
    <link rel="alternate" hreflang="it" href="https://pinsave.in/it/" />
    <link rel="alternate" hreflang="tr" href="https://pinsave.in/tr/" />
    <link rel="alternate" hreflang="id" href="https://pinsave.in/id/" />
    <link rel="alternate" hreflang="bn" href="https://pinsave.in/bn/" />
    <link rel="alternate" hreflang="x-default" href="https://pinsave.in/" />
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:title" content="Pinterest Video Downloader – Free HD Download Tool">
    <meta property="og:description" content="Download Pinterest videos and pins online in HD using our fast, free Pinterest Downloader. No registration or app needed!">
    <meta property="og:image" content="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']; ?>/img/og-image.jpg">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
    <meta property="twitter:title" content="Pinterest Video Downloader – Download in HD Free">
    <meta property="twitter:description" content="Download Pinterest videos for free with PinSave. Save videos in HD quality without watermark. Works with all Pinterest video posts.">
    <meta property="twitter:image" content="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']; ?>/assets/images/pinterest-downloader-social.jpg">
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="/css/main.css">
    
    <!-- Main JavaScript -->
    <script src="/js/app.js" defer></script>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon.svg">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon.svg">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon.svg">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/favicon.svg" color="#E60023">
    <meta name="theme-color" content="#E60023">
    
    <!-- JSON-LD Schema -->
    <?php
    // Initialize schema generator
    $schemaGenerator = new SchemaGenerator();
    $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];
    $schemaGenerator = new SchemaGenerator($baseUrl, 'PinSave');
    
    // Set social profiles if available
    if (isset($adminConfig['social_profiles'])) {
        $schemaGenerator->setSocialProfiles($adminConfig['social_profiles']);
    }
    
    // Generate website schema
    echo '<script type="application/ld+json">' . PHP_EOL;
    echo $schemaGenerator->generateWebsiteSchema();
    echo PHP_EOL . '</script>' . PHP_EOL;
    
    // Generate organization schema
    echo '<script type="application/ld+json">' . PHP_EOL;
    echo $schemaGenerator->generateOrganizationSchema();
    echo PHP_EOL . '</script>' . PHP_EOL;
    
    // Generate FAQ schema for homepage
    if (basename($_SERVER['PHP_SELF']) == 'index.php' || $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php') {
        $faqQuestions = [
            ($lang === 'hi' ? 'पिंटरेस्ट वीडियो कैसे डाउनलोड करें?' : 
                ($lang === 'es' ? '¿Cómo descargar videos de Pinterest?' : 
                'How to download Pinterest videos?')) => 
            ($lang === 'hi' ? 'पिंटरेस्ट वीडियो लिंक को कॉपी करें, हमारे डाउनलोडर में पेस्ट करें, और HD क्वालिटी में डाउनलोड करें।' : 
                ($lang === 'es' ? 'Copie el enlace del video de Pinterest, péguelo en nuestro descargador y descárguelo en HD.' : 
                'Copy the Pinterest video link, paste it in our downloader, and download in HD quality.')),
            ($lang === 'hi' ? 'क्या पिन्टरेस्ट डाउनलोडर मुफ्त है?' : 
                ($lang === 'es' ? '¿Es gratuito el descargador de Pinterest?' : 
                'Is the Pinterest downloader free to use?')) => 
            ($lang === 'hi' ? 'हाँ, हमारा पिन्टरेस्ट डाउनलोडर पूरी तरह से मुफ्त है। कोई पंजीकरण या भुगतान की आवश्यकता नहीं है।' : 
                ($lang === 'es' ? 'Sí, nuestro descargador de Pinterest es completamente gratuito. No requiere registro ni pago.' : 
                'Yes, our Pinterest downloader is completely free. No registration or payment required.'))
        ];
        
        echo '<script type="application/ld+json">' . PHP_EOL;
        echo $schemaGenerator->generateFAQSchema($faqQuestions);
        echo PHP_EOL . '</script>' . PHP_EOL;
    }
    ?>
    
    <!-- Google Analytics -->
    <?php
    // Add Google Analytics if configured in admin settings
    if (isset($adminConfig['seo']['google_analytics_id'])) {
        echo '<script async src="https://www.googletagmanager.com/gtag/js?id=' . htmlspecialchars($adminConfig['seo']['google_analytics_id']) . '"></script>';
        echo '<script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag("js", new Date());
            gtag("config", "' . htmlspecialchars($adminConfig['seo']['google_analytics_id']) . '");
        </script>';
    }
    
    // Track page view for SEO analytics
    $currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $pageTitle = $seoTitle;
    $referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
    $seoAnalytics->trackPageView($currentUrl, $pageTitle, $referrer);
    ?>
    
    <!-- Stylesheets -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* Mobile Navigation Styles */
        @media (max-width: 1023px) {
            #nav-items {
                background: white;
                position: absolute;
                left: 0;
                right: 0;
                top: 100%;
                z-index: 50;
                border-top: 1px solid #e5e7eb;
                display: none;
            }
            
            #nav-items.show {
                display: block;
            }
        }
        
        /* Active States */
        .nav-item-active {
            color: #2563eb; /* blue-600 */
            background-color: #f3f4f6; /* gray-100 */
        }
    </style>
    
    <!-- Custom Region-Specific FAQ Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "How do I download Pinterest videos in the USA, UK, or Canada?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "You can use PinSave.in, a free Pinterest downloader available in the USA, UK, and Canada. Just paste the Pinterest video link and download it instantly—no app or login needed."
          }
        },
        {
          "@type": "Question",
          "name": "What is the best Pinterest downloader tool for iPhone in the UK or Australia?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "PinSave.in is a top choice in the UK and Australia for iPhone users. It's a browser-based tool that downloads Pinterest videos in HD without any watermark or app installation."
          }
        },
        {
          "@type": "Question",
          "name": "Is there a way to download Pinterest videos in Germany or Europe without an app?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes, PinSave.in works perfectly in Germany and other European countries. It's secure, doesn't require installation, and lets you download Pinterest content directly from your browser."
          }
        },
        {
          "@type": "Question",
          "name": "Can I download Pinterest videos in HD quality from Australia or Canada?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Absolutely. PinSave.in provides high-resolution downloads (720p, 1080p MP4) for users in Australia, Canada, and other regions. It's optimized for fast download speed across countries."
          }
        },
        {
          "@type": "Question",
          "name": "What is the safest Pinterest video downloader for users in the US, UK, and EU?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "PinSave.in is trusted by users in the US, UK, and EU. It doesn't collect personal data, requires no login, and works on all devices—making it one of the safest Pinterest downloaders globally."
          }
        }
      ]
    }
    </script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Navigation Menu -->
        <nav class="bg-white py-4 border-b">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center">
                    <!-- Logo -->
                    <a href="/" class="flex items-center">
                        <svg class="h-6 w-6 text-[#E60023]" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4ZM3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12Z M12 16L12 8 M12 16L8 12 M12 16L16 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="ml-2 text-lg font-medium text-[#E60023]">PinSave</span>
                    </a>
                    <!-- Mobile menu button -->
                    <button id="mobileMenuBtn" class="text-gray-500 hover:text-gray-600 lg:hidden">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <!-- Desktop Menu items -->
                    <div class="hidden lg:flex lg:items-center lg:space-x-8">
                        <a href="/" class="text-gray-600 hover:text-[#E60023] text-sm">Home</a>
                        <a href="/pages/about.php" class="text-gray-600 hover:text-[#E60023] text-sm">About</a>
                        <a href="/pages/blog.php" class="text-gray-600 hover:text-[#E60023] text-sm">Blog</a>
                        <a href="/pages/faq.php" class="text-gray-600 hover:text-[#E60023] text-sm">FAQ</a>
                        <a href="/pages/contact.php" class="text-gray-600 hover:text-[#E60023] text-sm">Contact</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div class="lg:hidden">
            <div id="mobileMenu" class="hidden bg-white border-t border-gray-200 py-2">
                <div class="container mx-auto px-4 space-y-1">
                    <a href="/" class="block px-3 py-2 text-blue-600 hover:text-blue-800 font-medium">Home</a>
                    <a href="/pages/about.php" class="block px-3 py-2 text-blue-600 hover:text-blue-800 font-medium">About</a>
                    <a href="/pages/blog.php" class="block px-3 py-2 text-blue-600 hover:text-blue-800 font-medium">Blog</a>
                    <a href="/pages/faq.php" class="block px-3 py-2 text-blue-600 hover:text-blue-800 font-medium">FAQ</a>
                    <a href="/pages/contact.php" class="block px-3 py-2 text-blue-600 hover:text-blue-800 font-medium">Contact</a>
                </div>
            </div>
        </div>

        <!-- Mobile Menu functionality now handled by app.js -->
