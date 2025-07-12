        <!-- Compact Modern Footer -->
        <style>
        /* Footer gradient styles */
        .gradient-primary {
            background: linear-gradient(135deg, #E60023 0%, #FF4B2B 100%);
        }
        </style>
        <footer class="mt-8">
            <!-- Main Footer with Gradient Background -->
            <div class="gradient-primary text-white py-6 rounded-t-lg relative overflow-hidden">
                <!-- Background Pattern (subtle) -->
                <div class="absolute inset-0 opacity-5">
                    <div class="absolute inset-0" style="background-image: radial-gradient(circle at 20% 50%, #ffffff 0%, transparent 40%);"></div>
                </div>
                
                <div class="container mx-auto px-4 relative z-10">
                    <!-- Compact Footer Layout -->
                    <div class="flex flex-wrap justify-between mb-4">
                        <!-- Quick Links -->
                        <div class="w-full md:w-auto mb-4 md:mb-0">
                            <h3 class="text-sm font-semibold text-white mb-2">Quick Links</h3>
                            <div class="flex flex-wrap gap-x-4 gap-y-1">
                                <a href="/" class="text-xs text-white/80 hover:text-white transition-all">Home</a>
                                <a href="/pages/about.php" class="text-xs text-white/80 hover:text-white transition-all">About</a>
                                <a href="/pages/blog.php" class="text-xs text-white/80 hover:text-white transition-all">Blog</a>
                                <a href="/pages/faq.php" class="text-xs text-white/80 hover:text-white transition-all">FAQ</a>
                                <a href="/pages/contact.php" class="text-xs text-white/80 hover:text-white transition-all">Contact</a>
                                <a href="/pages/privacy.php" class="text-xs text-white/80 hover:text-white transition-all">Privacy</a>
                                <a href="/pages/terms.php" class="text-xs text-white/80 hover:text-white transition-all">Terms</a>
                                <a href="/pages/dmca.php" class="text-xs text-white/80 hover:text-white transition-all">DMCA</a>
                            </div>
                        </div>
                        
                        <!-- Resources Links (Dynamic) -->
                        <?php if (!empty($footerConfig['links'])): ?>
                        <div class="w-full md:w-auto">
                            <h3 class="text-sm font-semibold text-white mb-2">Resources</h3>
                            <div class="flex flex-wrap gap-x-4 gap-y-1">
                                <?php foreach ($footerConfig['links'] as $link): ?>
                                <?php if (!empty($link['text']) && !empty($link['url'])): ?>
                                <a href="<?php echo htmlspecialchars($link['url']); ?>" class="text-xs text-white/80 hover:text-white transition-all">
                                    <?php echo htmlspecialchars($link['text']); ?>
                                </a>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Disclaimer (Compact) -->
                    <div class="border-t border-white/10 pt-3 mb-3">
                        <h4 class="text-center font-bold text-sm text-white mb-2">Disclaimer</h4>
                        <p class="text-xs text-white/70">
                            pinsave.in is an independent tool designed to help users download publicly available content for personal use only. We do not host any copyrighted, pirated, or illegal content on our servers. All images and videos are fetched directly from Pinterest's publicly accessible Content Delivery Network (CDN) servers. We are not affiliated, associated, authorized, endorsed by, or in any way officially connected with Pinterest or any of its subsidiaries or affiliates. The name 'Pinterest' and all related trademarks are the property of their respective owners.
                        </p>
                    </div>
                    
                    <!-- Copyright -->
                    <div class="text-center">
                        <p class="text-xs font-bold text-white/80">
                            © 2025 pinsave.in - All Rights Reserved
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
