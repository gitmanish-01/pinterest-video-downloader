
# Pinterest Video Downloader

🚀 **PinSave.in** is a free and fast tool to download Pinterest videos, images, and GIFs online — no login or app required.

---

## 🔗 Visit: [https://pinsave.in](https://pinsave.in)

![Pinterest Video Downloader Preview](https://pinsave.in/assets/pinsave-preview.png)

---

## ✅ Features

- 📥 Download Pinterest videos in HD quality
- 🖼 Download images and GIFs instantly
- ⚡ Fast, secure, and mobile-friendly
- 🚫 No signup or software installation
- 💯 Completely free forever

---

## 📚 How to Use

1. Copy the Pinterest video/image link
2. Visit [https://pinsave.in](https://pinsave.in)
3. Paste the link into the input box
4. Click **Download**

---

## 📸 Screenshots

> Here's how PinSave.in looks:

![Screenshot](https://pinsave.in/assets/screenshot.jpg)

---

## 💡 Why PinSave.in?

PinSave.in was created to help users easily save valuable content from Pinterest without hassle. It's 100% web-based, so you don’t need to install anything.

---

## 📢 Share This Tool

Help others by sharing this GitHub project or the website:
- Website: [https://pinsave.in](https://pinsave.in)
- GitHub Repo: `https://github.com/yourusername/pinterest-video-downloader`

---

## 📲 Social Media Preview Tags (SEO)

```html
<!-- Open Graph / Facebook -->
<meta property="og:title" content="Pinterest Video Downloader - Free Tool | PinSave.in">
<meta property="og:description" content="Download Pinterest videos, GIFs, and images in HD quality. 100% free and mobile-friendly tool. No app or login required.">
<meta property="og:image" content="https://pinsave.in/assets/pinsave-preview.png">
<meta property="og:url" content="https://pinsave.in">
<meta property="og:type" content="website">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Pinterest Video Downloader - PinSave.in">
<meta name="twitter:description" content="Free Pinterest video downloader to save videos, images, and GIFs in HD. Easy and fast. No signup.">
<meta name="twitter:image" content="https://pinsave.in/assets/pinsave-preview.png">



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
