# Notch64 Laravel Website

> **No, not that Notch.**

Personal website for Notch64 - The Wonderful Works of Notch64. Built with Laravel and featuring a retro gaming aesthetic.

## 🎮 About

This is the official website for **Notch64**, showcasing gaming content, music, creative work, and community engagement. The site features:

- Dynamic splash messages
- Links to gaming (Vice Gamers), music (Big Notch), creative projects (Vicers), and community
- Social media integration (Bluesky, Twitch, YouTube, TikTok, Instagram, SoundCloud, Discord, Facebook)
- Retro pixel art design with Press Start 2P font
- Auto-playing background music

## 🚀 Tech Stack

- **Framework:** Laravel 11.x
- **Database:** SQLite
- **Frontend:** Blade templates, vanilla JavaScript, custom CSS
- **Assets:** Retro gaming graphics, pixel art, custom audio

## 📦 Installation

### Prerequisites

- PHP 8.2 or higher
- Composer
- SQLite

### Setup

```bash
# Clone the repository
git clone https://github.com/YOUR_USERNAME/notch64-laravel.git
cd notch64-laravel

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# (Optional) Seed the database with splash messages
php artisan db:seed

# Serve the application
php artisan serve
```

Visit `http://localhost:8000` to view the site.

## ⚙️ Configuration

### Link Configuration

All navigation and social media links are centralized in `config/notch64.php`:

```php
'nav' => [
    'gaming'    => 'https://www.vicegamers.com',
    'music'     => 'https://www.bignotch.com',
    'creative'  => 'https://www.vicers.net',
    'community' => 'https://www.vicers.net',
    'patreon'   => 'https://www.patreon.com/Notch64',
],

'social' => [
    'bluesky'    => 'https://bsky.app/profile/notch64.bsky.social',
    'twitch'     => 'https://www.twitch.com/itsnotch64',
    // ... more social links
],
```

Update these values to change where links point without editing templates.

## 🎨 Features

- **Splash Messages:** Dynamic, randomized messages fetched from database
- **Responsive Design:** Mobile-friendly retro layout
- **Audio Player:** Auto-playing background music (The Other Notch theme)
- **Social Links:** Quick access to all social media profiles
- **SEO Optimized:** Proper meta tags and descriptions

## 📁 Project Structure

```
├── app/
│   ├── Http/Controllers/
│   └── Models/
│       ├── SplashMessage.php
│       └── User.php
├── config/
│   └── notch64.php          # Custom configuration
├── database/
│   └── migrations/
│       └── 2026_02_21_235644_create_splash_message_table.php
├── public/
│   ├── audio/               # Background music
│   ├── css/                 # Custom stylesheets
│   ├── img/                 # Images and graphics
│   └── js/                  # JavaScript files
├── resources/
│   └── views/
│       └── home.blade.php   # Main landing page
└── routes/
    └── web.php
```

## 🤝 Contributing

This is a personal project, but suggestions and feedback are welcome!

## 📄 License

This project is private and proprietary.

---

Built with ❤️ by [fullstackhoward](https://howard.codes)

<p align="center">
<sub>Powered by <a href="https://laravel.com">Laravel</a></sub>
</p>

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
