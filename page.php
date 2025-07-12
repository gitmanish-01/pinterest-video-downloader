<?php
require_once 'config.php';

// Get the requested page slug
$slug = $_GET['slug'] ?? '';

// Find the page in the configuration
$page = null;
foreach ($config['pages'] as $pageData) {
    if ($pageData['slug'] === $slug) {
        $page = $pageData;
        break;
    }
}

// If page not found, redirect to home
if (!$page) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page['title']); ?> - PinterestDownloader</title>

    <!-- Schema.org Markup -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "HowTo",
        "name": "<?php echo htmlspecialchars($page['title']); ?>",
        "description": "<?php echo htmlspecialchars($page['meta_description']); ?>",
        "step": [
            {
                "@type": "HowToStep",
                "text": "Find the Pinterest content you want to download"
            },
            {
                "@type": "HowToStep",
                "text": "Copy the URL of the Pinterest post"
            },
            {
                "@type": "HowToStep",
                "text": "Paste the URL in our downloader"
            },
            {
                "@type": "HowToStep",
                "text": "Click Download and save to your device"
            }
        ],
        "tool": {
            "@type": "HowToTool",
            "name": "PinSave Pinterest Downloader"
        }
    }
    </script>
    <meta name="description" content="<?php echo htmlspecialchars($page['meta_description']); ?>">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <a href="index.php" class="text-2xl font-bold text-gray-800">PinterestDownloader</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold mb-6"><?php echo htmlspecialchars($page['title']); ?></h1>
            <div class="prose max-w-none">
                <?php echo nl2br(htmlspecialchars($page['content'])); ?>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
</body>
</html>
