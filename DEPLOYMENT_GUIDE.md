# PinSave Deployment Guide for Hostinger

This document provides step-by-step instructions for deploying the PinSave Pinterest Video Downloader application on a Hostinger hosting account.

## Prerequisites

- A Hostinger hosting account (Premium or Business plan recommended)
- Access to Hostinger control panel (hPanel)
- FTP client (like FileZilla) or File Manager in hPanel
- Your PinSave codebase ready for deployment

## Step 1: Prepare Your Environment Configuration

Before uploading your files, make sure your environment configuration is properly set up:

1. Edit the `config/env.php` file with your actual API keys:
   ```php
   <?php
   // Environment-specific configuration - DO NOT commit to version control
   
   // API Keys
   define('PINTEREST_API_KEY', 'your-actual-rapidapi-key-here');
   define('PINTEREST_API_HOST', 'pinterest-video-downloader1.p.rapidapi.com');
   
   // Debug settings
   define('DEBUG_MODE', false); // Set to false for production
   ```

2. Make sure your `.htaccess` file is properly configured (it should already be set up with all the necessary rules).

## Step 2: Upload Files to Hostinger

### Option 1: Using File Manager

1. Log in to your Hostinger account and access hPanel
2. Navigate to the File Manager
3. Go to the `public_html` directory (or create a subdirectory if you want to install in a subfolder)
4. Upload all PinSave files and directories, maintaining the same structure as in your local environment

### Option 2: Using FTP

1. Connect to your Hostinger server using an FTP client with the credentials provided in your Hostinger account
2. Navigate to the `public_html` directory (or desired subdirectory)
3. Upload all PinSave files and directories

## Step 3: Configure Domain Settings

1. If you're using a custom domain (like pinsave.in):
   - Make sure the domain is pointed to your Hostinger hosting (update nameservers or DNS records)
   - In hPanel, go to "Domains" → "Manage" and ensure your domain is properly set up

2. If you're using a subdomain:
   - In hPanel, go to "Domains" → "Subdomains"
   - Create a new subdomain and point it to the directory where you uploaded PinSave

## Step 4: Set Up Database (If Needed in the Future)

Currently, PinSave doesn't require a database. However, if you plan to add database functionality later:

1. In hPanel, go to "Databases" → "MySQL Databases"
2. Create a new database and user
3. Update the database credentials in your `config/env.php` file

## Step 5: Configure PHP Settings

Ensure your PHP settings are properly configured:

1. In hPanel, go to "Advanced" → "PHP Configuration"
2. Set PHP version to 7.4 or higher
3. Make sure these PHP extensions are enabled:
   - cURL
   - JSON
   - mbstring
   - fileinfo

## Step 6: Set File Permissions

Set the correct file permissions for security:

1. Directories should be set to 755 (drwxr-xr-x)
2. Files should be set to 644 (-rw-r--r--)
3. Ensure the `config` directory and sensitive files have restricted permissions

## Step 7: Test Your Installation

1. Visit your domain (e.g., https://pinsave.in) in a web browser
2. Test the Pinterest video downloading functionality
3. Check that all pages load correctly
4. Verify that SEO-friendly URLs are working
5. Test the sitemap by visiting https://pinsave.in/sitemap.xml

## Step 8: Set Up SSL Certificate

Secure your site with HTTPS:

1. In hPanel, go to "SSL/TLS"
2. Install a free Let's Encrypt SSL certificate for your domain
3. Enable HTTPS redirection in your `.htaccess` file by adding these lines at the top:
   ```
   # Redirect HTTP to HTTPS
   RewriteCond %{HTTPS} off
   RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
   ```

## Step 9: Submit Sitemap to Search Engines

1. Create accounts in Google Search Console and Bing Webmaster Tools
2. Verify ownership of your site
3. Submit your sitemap URL (https://pinsave.in/sitemap.xml)

## Troubleshooting

### Common Issues

1. **500 Internal Server Error**
   - Check PHP error logs in hPanel → "Logs" → "Error Logs"
   - Verify .htaccess file syntax
   - Ensure file permissions are correct

2. **API Not Working**
   - Confirm your RapidAPI key is correct in env.php
   - Check if your RapidAPI subscription is active

3. **SEO-Friendly URLs Not Working**
   - Make sure mod_rewrite is enabled on your server
   - Verify .htaccess file is properly uploaded and not corrupted

### Contacting Hostinger Support

If you encounter issues specific to the Hostinger hosting environment:

1. Access hPanel and use the live chat support
2. Be specific about your issue and include any error messages
3. Mention that you're running a PHP application with URL rewriting

## Maintenance

### Regular Updates

1. Keep your API keys secure and update them if necessary
2. Regularly check for any PHP security updates
3. Monitor your site's performance and error logs

### Backups

1. In hPanel, go to "Files" → "Backups"
2. Set up automatic backups or create manual backups regularly

---

For any questions or issues with the PinSave application itself (not hosting-related), refer to the main README.md file or contact the developer.
