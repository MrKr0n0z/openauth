# 🔐 Laravel OAuth 2.0 Social Login

A complete Laravel 11+ application implementing OAuth 2.0 social authentication with **Discord**, **Spotify**, **Twitch**, and **X (Twitter)** using Laravel Socialite and SocialiteProviders.

![Laravel](https://img.shields.io/badge/Laravel-11+-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

## ✨ Features

- 🎮 **Discord** OAuth integration
- 🎵 **Spotify** OAuth integration
- 📺 **Twitch** OAuth integration
- 🐦 **X/Twitter** OAuth integration
- 🔒 Secure session management
- 👤 User profile with avatar support
- 📱 Responsive UI with Tailwind CSS
- 🗄️ SQLite/MySQL database support
- 🚀 Easy deployment

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- MySQL or SQLite
- OAuth app credentials from Discord, Spotify, Twitch, and X/Twitter

### Installation

```bash
# Clone the repository
git clone https://github.com/yourusername/laravel-oauth-social-login.git
cd laravel-oauth-social-login

# Install dependencies
composer install

# Install Socialite packages
composer require laravel/socialite
composer require socialiteproviders/discord socialiteproviders/spotify
composer require socialiteproviders/twitch socialiteproviders/twitter

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database (SQLite example)
touch database/database.sqlite

# Run migrations
php artisan migrate

# Start the server
php artisan serve
```

Visit `http://localhost:8000` to see the application.

## 📚 Documentation

- **[INSTALLATION.md](INSTALLATION.md)** - Detailed installation instructions
- **[OAUTH_SETUP.md](OAUTH_SETUP.md)** - Step-by-step OAuth provider setup guides

## 🔧 Configuration

### Environment Variables

Add these to your `.env` file:

```env
# Discord
DISCORD_CLIENT_ID=your_client_id
DISCORD_CLIENT_SECRET=your_client_secret

# Spotify
SPOTIFY_CLIENT_ID=your_client_id
SPOTIFY_CLIENT_SECRET=your_client_secret

# Twitch
TWITCH_CLIENT_ID=your_client_id
TWITCH_CLIENT_SECRET=your_client_secret

# X/Twitter
X_CLIENT_ID=your_client_id
X_CLIENT_SECRET=your_client_secret
```

## 🛣️ Routes

| Method | URI | Description |
|--------|-----|-------------|
| GET | `/` | Home page with login buttons |
| GET | `/auth/{provider}/redirect` | Redirect to OAuth provider |
| GET | `/auth/{provider}/callback` | Handle OAuth callback |
| POST | `/logout` | Logout user |
| GET | `/dashboard` | User dashboard (protected) |

**Supported providers:** `discord`, `spotify`, `twitch`, `x-twitter`

## 📁 Project Structure

```
app/
├── Http/Controllers/AuthController.php    # OAuth authentication logic
├── Models/User.php                        # User model with OAuth fields
└── Providers/AppServiceProvider.php       # Socialite event listeners

config/services.php                        # OAuth provider configs

database/migrations/
└── 0001_01_01_000000_create_users_table.php  # User table migration

resources/views/
├── welcome.blade.php                      # Login page
└── dashboard.blade.php                    # Dashboard

routes/web.php                             # Application routes
```

## 🗄️ Database Schema

The `users` table includes:

```php
id                      - Primary key
name                    - User's display name
email                   - Email (nullable)
avatar                  - Profile picture URL (nullable)
provider                - OAuth provider (discord/spotify/twitch/x-twitter)
provider_id             - Provider's user ID
provider_token          - Access token (500 chars, nullable)
provider_refresh_token  - Refresh token (500 chars, nullable)
created_at, updated_at  - Timestamps
```

**Unique constraint:** `(provider, provider_id)` - Each provider ID is unique per provider

## 🔒 Security

- OAuth tokens stored securely in database
- CSRF protection enabled
- Session management with Laravel's built-in security
- Password field is nullable (OAuth-only auth)
- Environment variables for sensitive data

## 🚀 Deployment

### Production Checklist

1. ✅ Set `APP_ENV=production` in `.env`
2. ✅ Update `APP_URL` to your production domain
3. ✅ Use HTTPS (required by OAuth providers)
4. ✅ Update OAuth redirect URIs in provider dashboards
5. ✅ Set strong `APP_KEY`
6. ✅ Configure proper database credentials
7. ✅ Run `php artisan config:cache`
8. ✅ Run `php artisan route:cache`

### Update OAuth Callback URLs

Make sure to update redirect URIs in each provider's dashboard:
- Discord: `https://yourdomain.com/auth/discord/callback`
- Spotify: `https://yourdomain.com/auth/spotify/callback`
- Twitch: `https://yourdomain.com/auth/twitch/callback`
- X/Twitter: `https://yourdomain.com/auth/x-twitter/callback`

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📝 License

This project is open-source and available under the [MIT License](LICENSE).

## 🙏 Acknowledgments

- [Laravel](https://laravel.com/)
- [Laravel Socialite](https://laravel.com/docs/socialite)
- [SocialiteProviders](https://socialiteproviders.com/)
- [Tailwind CSS](https://tailwindcss.com/)

## 📧 Support

For questions or issues:
- Open an issue on GitHub
- Check [OAUTH_SETUP.md](OAUTH_SETUP.md) for provider-specific help
- Visit [Laravel Socialite Documentation](https://laravel.com/docs/socialite)

---

**Made with ❤️ using Laravel**
