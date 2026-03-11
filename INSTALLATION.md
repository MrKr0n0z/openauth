# 🚀 Quick Installation Guide

## Prerequisites

- PHP 8.2 or higher
- Composer
- MySQL or SQLite
- Node.js & NPM (optional, for asset compilation)

## Installation Steps

### 1. Install PHP Dependencies

```bash
composer install
```

### 2. Install Laravel Socialite & Providers

```bash
composer require laravel/socialite
composer require socialiteproviders/discord
composer require socialiteproviders/spotify
composer require socialiteproviders/twitch
composer require socialiteproviders/twitter
```

### 3. Set Up Environment

```bash
# Copy the environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure your database in .env
# For SQLite (default):
touch database/database.sqlite

# For MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=your_database
# DB_USERNAME=your_username
# DB_PASSWORD=your_password
```

### 4. Run Database Migrations

```bash
php artisan migrate
```

### 5. Configure OAuth Providers

Add your OAuth credentials to `.env`:

```env
# Discord
DISCORD_CLIENT_ID=your_discord_client_id
DISCORD_CLIENT_SECRET=your_discord_client_secret

# Spotify
SPOTIFY_CLIENT_ID=your_spotify_client_id
SPOTIFY_CLIENT_SECRET=your_spotify_client_secret

# Twitch
TWITCH_CLIENT_ID=your_twitch_client_id
TWITCH_CLIENT_SECRET=your_twitch_client_secret

# X (Twitter)
X_CLIENT_ID=your_x_client_id
X_CLIENT_SECRET=your_x_client_secret
```

**See [OAUTH_SETUP.md](OAUTH_SETUP.md) for detailed instructions on obtaining these credentials.**

### 6. Start the Development Server

```bash
php artisan serve
```

The application will be available at: **http://localhost:8000**

## Testing OAuth Login

1. Visit `http://localhost:8000`
2. Click on any social login button
3. Authorize the application
4. You'll be redirected to the dashboard

## File Structure

```
app/
├── Http/
│   └── Controllers/
│       └── AuthController.php      # OAuth authentication logic
├── Models/
│   └── User.php                    # User model with OAuth fields
├── Providers/
│   └── AppServiceProvider.php      # Socialite event listeners
config/
└── services.php                    # OAuth provider configurations
database/
└── migrations/
    └── 0001_01_01_000000_create_users_table.php  # User table with OAuth fields
resources/
└── views/
    ├── welcome.blade.php           # Login page
    └── dashboard.blade.php         # User dashboard
routes/
└── web.php                         # Application routes
```

## Available Routes

| Method | URI | Action | Name |
|--------|-----|--------|------|
| GET | `/` | Home page with login buttons | - |
| GET | `/auth/{provider}/redirect` | Redirect to OAuth provider | `auth.redirect` |
| GET | `/auth/{provider}/callback` | Handle OAuth callback | `auth.callback` |
| POST | `/logout` | Logout user | `logout` |
| GET | `/dashboard` | User dashboard (protected) | `dashboard` |

**Supported providers:** `discord`, `spotify`, `twitch`, `x-twitter`

## Troubleshooting

### "Class 'SocialiteProviders\Manager\SocialiteWasCalled' not found"

Install the SocialiteProviders manager:
```bash
composer require socialiteproviders/manager
```

### "Invalid redirect URI" Error

Make sure your callback URLs in the OAuth provider dashboard match exactly:
- Discord: `http://localhost:8000/auth/discord/callback`
- Spotify: `http://localhost:8000/auth/spotify/callback`
- Twitch: `http://localhost:8000/auth/twitch/callback`
- X/Twitter: `http://localhost:8000/auth/x-twitter/callback`

### "Session store not set on request" Error

Run:
```bash
php artisan config:clear
php artisan cache:clear
```

### Database Connection Issues

For SQLite, ensure the file exists:
```bash
touch database/database.sqlite
```

For MySQL/PostgreSQL, verify your database credentials in `.env`.

## Next Steps

- 📖 Read [OAUTH_SETUP.md](OAUTH_SETUP.md) for detailed OAuth provider setup
- 🔒 Configure additional scopes for each provider
- 🎨 Customize the UI in `resources/views/`
- 🚀 Deploy to production (remember to use HTTPS!)

## Support

For issues or questions:
- **Laravel Socialite**: https://laravel.com/docs/socialite
- **SocialiteProviders**: https://socialiteproviders.com/

---

**Happy Coding! 🎉**
