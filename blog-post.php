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

// Get post ID or slug from URL
$post_id = isset($_GET['id']) ? $_GET['id'] : null;
$post_slug = isset($_GET['slug']) ? $_GET['slug'] : null;

// Initialize variables
$post = null;
$notFound = true;

// Load admin configuration
$configPath = __DIR__ . '/admin/config.json';
$adminConfig = [];
$footerConfig = [];

if (file_exists($configPath)) {
    $adminConfig = json_decode(file_get_contents($configPath), true) ?: [];
    $footerConfig = $adminConfig['footer'] ?? [];
}

// Find post by ID or slug
if (!empty($adminConfig['posts'])) {
    if ($post_id && isset($adminConfig['posts'][$post_id])) {
        $post = $adminConfig['posts'][$post_id];
        $post['id'] = $post_id; // Add ID to post data
        $notFound = false;
    } elseif ($post_slug) {
        foreach ($adminConfig['posts'] as $id => $p) {
            if (isset($p['slug']) && $p['slug'] === $post_slug) {
                $post = $p;
                $post['id'] = $id; // Add ID to post data
                $notFound = false;
                break;
            }
        }
    }
}

// Check if post is public
if (!$notFound && isset($post['visibility']) && $post['visibility'] !== 'public') {
    $notFound = true;
}

// Set page title and meta information for header.php
if (!$notFound) {
    $metaTitle = $post['title'];
    $metaDescription = substr(strip_tags($post['content']), 0, 160);
    $metaKeywords = !empty($post['tags']) && is_array($post['tags']) ? implode(', ', $post['tags']) : 'blog, article';
} else {
    $metaTitle = 'Post Not Found';
    $metaDescription = 'The requested blog post could not be found.';
    $metaKeywords = 'blog, post, not found';
}

// Track page visit
$stats_handler->logVisitor($ip, $user_agent, $country);

// Include header
require_once 'header.php';
?>

<style>
    /* Modern CSS Variables - Match with main page */
    :root {
        --primary-color: #E60023;
        --primary-hover: #BD081C;
        --secondary-color: #FF4B2B;
        --accent-color: #FFE0E6;
        --text-primary: #2D3748;
        --text-secondary: #718096;
        --bg-light: #F7FAFC;
        --bg-white: #FFFFFF;
    }
    
    /* Modern animations */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    .animate-slide-in {
        animation: slideInUp 0.6s ease-out;
    }
    
    .animate-fade-in {
        animation: fadeIn 0.8s ease-out;
    }
    
    /* Modern gradient backgrounds */
    .gradient-primary {
        background: linear-gradient(135deg, #E60023 0%, #FF4B2B 100%);
    }
    
    /* Glass morphism effect */
    .glass-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    
    /* Blog content styles */
    .blog-content img {
        max-width: 100%;
        height: auto;
        margin: 1.5rem 0;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    
    .blog-content h2 {
        font-size: 1.75rem;
        font-weight: 700;
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: var(--text-primary);
    }
    
    .blog-content h3 {
        font-size: 1.4rem;
        font-weight: 600;
        margin-top: 1.75rem;
        margin-bottom: 0.75rem;
        color: var(--text-primary);
    }
    
    .blog-content p {
        margin-bottom: 1.25rem;
        color: var(--text-secondary);
        line-height: 1.7;
    }
    
    .blog-content ul, .blog-content ol {
        margin-left: 1.5rem;
        margin-bottom: 1.25rem;
        color: var(--text-secondary);
        line-height: 1.7;
    }
    
    .blog-content ul {
        list-style-type: disc;
    }
    
    .blog-content ol {
        list-style-type: decimal;
    }
    
    .blog-content a {
        color: var(--primary-color);
        text-decoration: none;
        transition: all 0.2s ease;
    }
    
    .blog-content a:hover {
        color: var(--primary-hover);
        text-decoration: underline;
    }
    
    /* Modern button styles */
    .btn-primary {
        background: linear-gradient(135deg, #E60023 0%, #FF4B2B 100%);
        border: none;
        color: white;
        font-weight: 500;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(230, 0, 35, 0.3);
    }
</style>

<?php if (!$notFound): ?>
<!-- JSON-LD structured data for Blog Article -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BlogPosting",
    "headline": "<?php echo htmlspecialchars($post['title'] ?? 'Blog Post'); ?>",
    "description": "<?php echo htmlspecialchars($metaDescription); ?>",
    "image": "<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']; ?>/img/pinsave-preview.jpg",
    "datePublished": "<?php echo date('c', strtotime($post['created_at'] ?? 'now')); ?>",
    "dateModified": "<?php echo date('c', strtotime($post['updated_at'] ?? $post['created_at'] ?? 'now')); ?>",
    "author": {
        "@type": "Organization",
        "name": "PinSave",
        "url": "<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']; ?>"
    },
    "publisher": {
        "@type": "Organization",
        "name": "PinSave",
        "logo": {
            "@type": "ImageObject",
            "url": "<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']; ?>/pinlogo.png"
        }
    },
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"
    },
    <?php if (!empty($post['tags']) && is_array($post['tags'])): ?>
    "keywords": "<?php echo htmlspecialchars(implode(', ', $post['tags'])); ?>",
    <?php endif; ?>
    "articleSection": "<?php echo htmlspecialchars($post['category'] ?? 'Blog'); ?>"
}
</script>
<?php endif; ?>
        
<!-- Hero Section with Modern Design -->
<section class="relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 20% 50%, #E60023 0%, transparent 50%), radial-gradient(circle at 80% 50%, #FF4B2B 0%, transparent 50%);"></div>
    </div>
    
    <div class="relative gradient-primary text-white py-12 md:py-16 rounded-b-[3rem]">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center animate-slide-in">
                <?php if (!$notFound): ?>
                    <h1 class="text-3xl md:text-4xl font-bold mb-3"><?php echo htmlspecialchars($post['title'] ?? 'Blog Post'); ?></h1>
                    <div class="flex flex-wrap justify-center items-center text-white/80 text-sm gap-4 mt-4">
                        <span class="flex items-center">
                            <i class="far fa-calendar-alt mr-2"></i>
                            <?php echo isset($post['created_at']) ? date('M j, Y', strtotime($post['created_at'])) : date('M j, Y'); ?>
                        </span>
                        
                        <?php if (!empty($post['category'])): ?>
                        <span class="flex items-center">
                            <i class="far fa-folder mr-2"></i>
                            <?php echo htmlspecialchars($post['category']); ?>
                        </span>
                        <?php endif; ?>
                        
                        <?php if (!empty($post['tags']) && is_array($post['tags'])): ?>
                        <span class="flex items-center">
                            <i class="fas fa-tags mr-2"></i>
                            <?php echo htmlspecialchars(implode(', ', $post['tags'])); ?>
                        </span>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <h1 class="text-3xl md:text-4xl font-bold mb-3">Post Not Found</h1>
                    <p class="text-white/80 text-lg">The blog post you're looking for doesn't exist or isn't available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Main Content Section -->
<section class="container mx-auto px-4 py-12 -mt-10 relative z-10">
    <div class="max-w-4xl mx-auto">
        <?php if ($notFound): ?>
            <!-- Not Found Message with Modern Design -->
            <div class="glass-card rounded-3xl p-8 text-center animate-fade-in">
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-exclamation-triangle text-3xl text-red-500"></i>
                </div>
                <p class="text-gray-600 mb-8">We couldn't find the blog post you were looking for. It may have been moved or deleted.</p>
                <a href="pages/blog.php" class="btn-primary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Blog
                </a>
            </div>
        <?php else: ?>
            <!-- Blog Post Content with Modern Design -->
            <div class="glass-card rounded-3xl overflow-hidden animate-fade-in">
                <?php if (!empty($post['image'])): ?>
                <div class="h-64 md:h-80 overflow-hidden">
                    <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars($post['title'] ?? ''); ?>" class="w-full h-full object-cover">
                </div>
                <?php endif; ?>
                
                <div class="p-8 md:p-10">
                    <div class="blog-content prose max-w-none">
                        <?php echo $post['content'] ?? 'Content not available'; ?>
                    </div>
                    
                    <!-- Back to Blog Link with Modern Design -->
                    <div class="mt-10 pt-6 border-t border-gray-200">
                        <a href="pages/blog.php" class="btn-primary">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Blog
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Related Posts Section (if available) -->
            <?php 
            $relatedPosts = [];
            if (!empty($post['category']) && !empty($adminConfig['posts'])) {
                foreach ($adminConfig['posts'] as $id => $p) {
                    if ($id !== ($post['id'] ?? '') && isset($p['visibility']) && $p['visibility'] === 'public' 
                        && isset($p['category']) && $p['category'] === $post['category'] && count($relatedPosts) < 2) {
                        $p['slug'] = $p['slug'] ?? $id;
                        $relatedPosts[] = $p;
                    }
                }
            }
            
            if (!empty($relatedPosts)): 
            ?>
            <div class="mt-12">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Related Articles</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <?php foreach ($relatedPosts as $related): ?>
                    <div class="glass-card blog-card rounded-3xl overflow-hidden animate-fade-in">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-3">
                                <a href="blog-post.php?slug=<?php echo urlencode($related['slug'] ?? ''); ?>" class="hover:text-red-600 transition-colors">
                                    <?php echo htmlspecialchars($related['title']); ?>
                                </a>
                            </h3>
                            
                            <div class="text-gray-600 mb-4 line-clamp-2">
                                <?php 
                                $excerpt = strip_tags($related['content']);
                                $excerpt = substr($excerpt, 0, 120);
                                echo htmlspecialchars($excerpt) . (strlen(strip_tags($related['content'])) > 120 ? '...' : '');
                                ?>
                            </div>
                            
                            <a href="blog-post.php?slug=<?php echo urlencode($related['slug'] ?? ''); ?>" class="text-red-600 hover:text-red-700 font-medium inline-flex items-center gap-1">
                                Read Article
                                <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<?php
// Include footer
require_once 'footer.php';
?>
