# PinSave - Pinterest Video Downloader

A web application that allows users to download videos from Pinterest using RapidAPI.

## Features

- Download Pinterest videos by pasting the URL
- Modern and responsive UI using Tailwind CSS
- Video preview before downloading
- Error handling and validation
- SEO-friendly URLs for blog posts and articles
- Dynamic sitemap generation
- Secure API key management

## Requirements

- PHP 7.2 or higher
- XAMPP, WAMP, or similar local server environment
- RapidAPI key for Pinterest video downloader API

## Setup Instructions

1. Clone or download this repository to your local server directory (e.g., `htdocs` for XAMPP)
2. Open `api/pinterest_api.php` and add your RapidAPI key:
   ```php
   $rapidApiKey = "YOUR_RAPIDAPI_KEY_HERE";
   ```
3. Start your local server (Apache)
4. Access the application through your browser: `http://localhost/pinsave/`

## How to Use

1. Copy the URL of a Pinterest video you want to download
2. Paste the URL in the input field
3. Click the "Download Video" button
4. Wait for the video to process
5. Click the download button to save the video to your device

## RapidAPI Setup

1. Sign up for a RapidAPI account at [RapidAPI](https://rapidapi.com)
2. Subscribe to one of these APIs:
   - [Pinterest Video and Image Downloader](https://rapidapi.com/markedward/api/pinterest-video-and-image-downloader)
   - [Social Media Video Downloader](https://rapidapi.com/ytjar/api/social-media-video-downloader)
3. Copy your API key from RapidAPI dashboard
4. Paste it in the `pinterest_api.php` file

## SEO and URL Improvements

### SEO-Friendly URLs
- Blog posts now use slug-based URLs: `/blog/{slug}` instead of query parameters
- URL rewriting rules added in `.htaccess` to support clean URLs
- Legacy URL support maintained for backward compatibility

### Dynamic Sitemap
- Sitemap.php now dynamically generates XML sitemap
- Includes all blog posts with proper last modified dates
- Uses current protocol and domain to avoid mixed content issues

### Security Improvements
- API keys moved to environment configuration file
- Fallback mechanisms for configuration
- Proper HTTP headers for caching and compression

### Content Fixes
- Fixed syntax errors in page content
- Replaced non-standard Tailwind CSS color classes
- Improved error handling for 404 pages

## License

This project is for personal use only.

## Disclaimer

This tool is intended for personal use only. Please respect Pinterest's terms of service and copyright laws when downloading and using content.
