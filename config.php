<?php
/**
 * PinSave Configuration File
 * 
 * This file contains all the configuration settings for the PinSave application.
 * Settings can be managed through the admin panel.
 */

// Load environment-specific configuration (API keys, etc.)
$envFile = __DIR__ . '/config/env.php';
if (file_exists($envFile)) {
    require_once $envFile;
} else {
    // Fallback definitions if env.php doesn't exist
    define('PINTEREST_API_KEY', '4e95129c77msh450d4d435c7cbe1p1b6608jsna3349d7b7a56');
    define('PINTEREST_API_HOST', 'pinterest-video-downloader1.p.rapidapi.com');
    define('DEBUG_MODE', true);
}

// Load admin settings if available
$adminConfigFile = __DIR__ . '/config/admin_settings.json';
$adminConfig = [];

if (file_exists($adminConfigFile)) {
    $adminConfigData = json_decode(file_get_contents($adminConfigFile), true);
    if (is_array($adminConfigData)) {
        $adminConfig = $adminConfigData;
    }
}

// RapidAPI Configuration - Use env.php values if available, otherwise use admin settings
if (!defined('PINTEREST_API_KEY')) {
    define('PINTEREST_API_KEY', $adminConfig['api']['rapidapi_key'] ?? '4e95129c77msh450d4d435c7cbe1p1b6608jsna3349d7b7a56');
}

// API Selection
// Options: 'pinterest-video-downloader1' or other providers
define('API_PROVIDER', $adminConfig['api']['api_provider'] ?? 'pinterest-video-downloader1');

// Application Settings
define('APP_NAME', 'PinSave');
define('APP_DESCRIPTION', 'Pinterest Video Downloader');
define('APP_VERSION', '1.0.0');

// Debug Mode (set to false in production)
if (!defined('DEBUG_MODE')) {
    define('DEBUG_MODE', $adminConfig['api']['debug_mode'] ?? true);
}

// SEO Settings
$seoTitle = $adminConfig['seo']['title'] ?? 'Free Pinterest Video Downloader - Save Pinterest Videos Easily | PinSave';
$seoDescription = $adminConfig['seo']['description'] ?? 'Download Pinterest videos for free with PinSave. Save Pinterest videos in HD quality without watermark. Works with pin.it links and all Pinterest video posts.';
$seoKeywords = $adminConfig['seo']['keywords'] ?? 'pinterest video downloader, download pinterest videos, save pinterest videos, pinterest video saver, pin.it video downloader, pinterest reels downloader, pinterest downloader, pinterest video download, download video pinterest, pinterest com download, pinterest video downloader app, download video from pinterest, pinterest download video, download pinterest images, pinterest photo download, download pinterest video, pinterest downloader apk, pinterest video downloader apk, download video from pinterest link, pinterest downloader for iphone, download pinterest videos in usa, pinterest video download HD no login, pinterest downloader for school projects, best pinterest downloader 2025 USA, pinterest downloader video, pinterest downloader apk, best pinterest video downloader, pinterest video download full hd 1080p, instagram downloader, pinterest video download hd, pinterest video download status, pinterest video downloader chrome, pinterest video, convert pinterest video to mp4, pinterest videos saver in mobile, pinterest videos saver in chrome, pinterest videos saver extension, pinterest video to gif, pinterest video downloader iphone';
$seoH1 = $adminConfig['seo']['h1'] ?? 'Pinterest Video Downloader';
$seoCanonicalUrl = $adminConfig['seo']['canonical_url'] ?? '';
$seoFocusKeywords = $adminConfig['seo']['focus_keywords'] ?? '';
$seoRobotsMeta = $adminConfig['seo']['robots_meta'] ?? 'index, follow';

// Ad Settings
$googleAdsEnabled = $adminConfig['ads']['google_ads']['enabled'] ?? false;
$googleAdsPublisherId = $adminConfig['ads']['google_ads']['publisher_id'] ?? '';
$googleAdsSlotTop = $adminConfig['ads']['google_ads']['ad_slot_top'] ?? '';
$googleAdsSlotBottom = $adminConfig['ads']['google_ads']['ad_slot_bottom'] ?? '';
$googleAdsSlotSidebar = $adminConfig['ads']['google_ads']['ad_slot_sidebar'] ?? '';

$ezoicAdsEnabled = $adminConfig['ads']['ezoic_ads']['enabled'] ?? false;
$ezoicSiteId = $adminConfig['ads']['ezoic_ads']['site_id'] ?? '';
$ezoicScript = $adminConfig['ads']['ezoic_ads']['script'] ?? '';

// Articles
$articles = $adminConfig['articles'] ?? [];

// Footer Settings
$footerConfig = $adminConfig['footer'] ?? [
    'disclaimer' => 'PinterestDownloader does not host any pirated or copyright content on its server, and all videos or images that you download from our tool are downloaded from their respective CDN servers. And this Tool is Not associated with Pinterest in any ways.',
    'copyright_text' => '© ' . date('Y') . ' - PinterestDownloader',
    'links' => [
        'about' => [
            'text' => 'About us',
            'url' => 'pages/about.php'
        ],
        'privacy' => [
            'text' => 'Privacy Policy',
            'url' => 'pages/privacy.php'
        ],
        'contact' => [
            'text' => 'Contact us',
            'url' => 'pages/contact.php'
        ],
        'faq' => [
            'text' => 'FAQ',
            'url' => 'pages/faq.php'
        ],
        'dmca' => [
            'text' => 'DMCA Policy',
            'url' => 'pages/dmca.php'
        ],
        'terms' => [
            'text' => 'Terms of Service',
            'url' => 'pages/terms.php'
        ]
    ]
];
?>
