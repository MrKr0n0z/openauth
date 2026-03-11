# Laravel OAuth 2.0 Social Login - Setup Guide

This Laravel application implements OAuth 2.0 social authentication with **Discord**, **Spotify**, **Twitch**, and **X (Twitter)** using Laravel Socialite and SocialiteProviders.

## Table of Contents
1. [Installation](#installation)
2. [Discord Setup](#discord-setup)
3. [Spotify Setup](#spotify-setup)
4. [Twitch Setup](#twitch-setup)
5. [X/Twitter Setup](#xtwitter-setup)
6. [Running the Application](#running-the-application)

---

## Installation

### 1. Install Dependencies

```bash
composer require laravel/socialite
composer require socialiteproviders/discord
composer require socialiteproviders/spotify
composer require socialiteproviders/twitch
composer require socialiteproviders/twitter
```

### 2. Configure Service Providers

Add the following to `config/app.php` in the `providers` array:

```php
'providers' => ServiceProvider::defaultProviders()->merge([
    // ...
    Laravel\Socialite\SocialiteServiceProvider::class,
    \SocialiteProviders\Manager\ServiceProvider::class,
])->toArray(),
```

### 3. Add Event Listeners

In `app/Providers/AppServiceProvider.php`, add to the `boot()` method:

```php
use Illuminate\Support\Facades\Event;
use SocialiteProviders\Manager\SocialiteWasCalled;

public function boot(): void
{
    Event::listen(function (SocialiteWasCalled $event) {
        $event->extendSocialite('discord', \SocialiteProviders\Discord\Provider::class);
        $event->extendSocialite('spotify', \SocialiteProviders\Spotify\Provider::class);
        $event->extendSocialite('twitch', \SocialiteProviders\Twitch\Provider::class);
        $event->extendSocialite('x-twitter', \SocialiteProviders\Twitter\Provider::class);
    });
}
```

### 4. Copy Environment File

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Run Migrations

```bash
php artisan migrate
```

---

## Discord Setup

### Step 1: Create a Discord Application

1. Go to the **Discord Developer Portal**: https://discord.com/developers/applications
2. Click **"New Application"**
3. Enter a name for your application (e.g., "My Laravel App")
4. Click **"Create"**

### Step 2: Configure OAuth2

1. In the left sidebar, click **"OAuth2"**
2. Click **"General"**
3. Under **"Redirects"**, click **"Add Redirect"**
4. Add your callback URL: `http://localhost:8000/auth/discord/callback` (or your production URL)
5. Click **"Save Changes"**

### Step 3: Get Credentials

1. In **"OAuth2" → "General"**, copy the **Client ID**
2. Click **"Reset Secret"** to generate a new **Client Secret**, then copy it

### Step 4: Add to .env

```env
DISCORD_CLIENT_ID=your_client_id_here
DISCORD_CLIENT_SECRET=your_client_secret_here
DISCORD_REDIRECT_URI="${APP_URL}/auth/discord/callback"
```

### Required Scopes

The default scopes are `identify` and `email`. Discord will automatically request these.

---

## Spotify Setup

### Step 1: Create a Spotify App

1. Go to the **Spotify Developer Dashboard**: https://developer.spotify.com/dashboard
2. Log in with your Spotify account
3. Click **"Create app"**
4. Fill in:
   - **App name**: "My Laravel App"
   - **App description**: "OAuth authentication app"
   - **Redirect URI**: `http://localhost:8000/auth/spotify/callback`
   - Check the **Terms of Service** box
5. Click **"Save"**

### Step 2: Get Credentials

1. Click on your newly created app
2. Click **"Settings"**
3. Copy the **Client ID**
4. Click **"View client secret"** and copy the **Client Secret**

### Step 3: Add Redirect URIs

1. In **Settings**, scroll to **"Redirect URIs"**
2. Add: `http://localhost:8000/auth/spotify/callback`
3. Add your production URL if deploying: `https://yourdomain.com/auth/spotify/callback`
4. Click **"Save"**

### Step 4: Add to .env

```env
SPOTIFY_CLIENT_ID=your_client_id_here
SPOTIFY_CLIENT_SECRET=your_client_secret_here
SPOTIFY_REDIRECT_URI="${APP_URL}/auth/spotify/callback"
```

### Required Scopes

The default scopes include `user-read-email` and `user-read-private`.

---

## Twitch Setup

### Step 1: Register Your Application

1. Go to the **Twitch Developer Console**: https://dev.twitch.tv/console
2. Log in with your Twitch account
3. Click **"Register Your Application"**
4. Fill in:
   - **Name**: "My Laravel App"
   - **OAuth Redirect URLs**: `http://localhost:8000/auth/twitch/callback`
   - **Category**: Choose "Website Integration" or appropriate category
5. Complete the CAPTCHA and click **"Create"**

### Step 2: Get Credentials

1. Click **"Manage"** on your application
2. Copy the **Client ID**
3. Click **"New Secret"** to generate a **Client Secret**, then copy it

### Step 3: Add to .env

```env
TWITCH_CLIENT_ID=your_client_id_here
TWITCH_CLIENT_SECRET=your_client_secret_here
TWITCH_REDIRECT_URI="${APP_URL}/auth/twitch/callback"
```

### Required Scopes

The default scopes include `user:read:email`.

---

## X/Twitter Setup

### Step 1: Create a Twitter/X Developer Account

1. Go to the **Twitter Developer Portal**: https://developer.twitter.com/
2. Sign up for a developer account (if you don't have one)
3. Complete the application process (may require approval)

### Step 2: Create a Project and App

1. Go to the **Developer Portal Dashboard**: https://developer.twitter.com/en/portal/dashboard
2. Click **"+ Create Project"**
3. Enter project details:
   - **Project name**: "My Laravel Project"
   - **Use case**: Choose appropriate option
   - **Project description**: Describe your app
4. Create an **App** within the project:
   - **App name**: "My Laravel App"

### Step 3: Configure OAuth 2.0

1. In your app settings, go to **"User authentication settings"**
2. Click **"Set up"**
3. Enable **OAuth 2.0**
4. Configure:
   - **Type of App**: Web App
   - **Callback URI / Redirect URL**: `http://localhost:8000/auth/x-twitter/callback`
   - **Website URL**: `http://localhost:8000`
5. **Permissions**: Request `Read` (or adjust as needed)
6. Save changes

### Step 4: Get Credentials

1. Go to the **"Keys and tokens"** tab
2. Under **OAuth 2.0 Client ID and Client Secret**:
   - Copy the **Client ID**
   - Copy the **Client Secret** (generate if needed)

### Step 5: Add to .env

```env
X_CLIENT_ID=your_client_id_here
X_CLIENT_SECRET=your_client_secret_here
X_REDIRECT_URI="${APP_URL}/auth/x-twitter/callback"
```

### Required Scopes

Twitter OAuth 2.0 uses scopes like `tweet.read`, `users.read`, `offline.access`.

---

## Running the Application

### 1. Start the Development Server

```bash
php artisan serve
```

The application will be available at: `http://localhost:8000`

### 2. Test OAuth Login

1. Navigate to `http://localhost:8000`
2. Click on any of the social login buttons:
   - Login with Discord
   - Login with Spotify
   - Login with Twitch
   - Login with X (Twitter)
3. Authorize the application on the provider's page
4. You'll be redirected back to the dashboard

### 3. View Dashboard

After successful authentication, you'll see:
- Your name
- Avatar (if available)
- Provider information
- OAuth details

### 4. Logout

Click the **"Logout"** button to end your session.

---

## Database Structure

The `users` table includes:

```php
- id (primary key)
- name (string)
- email (nullable string)
- avatar (nullable string)
- provider (string: 'discord', 'spotify', 'twitch', 'x-twitter')
- provider_id (string, unique per provider)
- provider_token (nullable string, 500 chars)
- provider_refresh_token (nullable string, 500 chars)
- timestamps
```

---

## Production Deployment

### Important Changes for Production:

1. **Update APP_URL** in `.env`:
   ```env
   APP_URL=https://yourdomain.com
   ```

2. **Update OAuth Redirect URIs** in each provider's dashboard:
   - Discord: `https://yourdomain.com/auth/discord/callback`
   - Spotify: `https://yourdomain.com/auth/spotify/callback`
   - Twitch: `https://yourdomain.com/auth/twitch/callback`
   - X: `https://yourdomain.com/auth/x-twitter/callback`

3. **Enable HTTPS**: OAuth providers require HTTPS in production

4. **Secure your .env file**: Never commit it to version control

---

## Troubleshooting

### Common Issues:

1. **"Invalid redirect URI"**
   - Ensure the redirect URI in your provider's dashboard matches exactly (including http/https)
   - Check for trailing slashes

2. **"Invalid client credentials"**
   - Double-check your Client ID and Client Secret
   - Regenerate secrets if needed

3. **"Scope not permitted"**
   - Verify your app has the required permissions in the provider's dashboard

4. **Session/CSRF token errors**
   - Clear your browser cache and cookies
   - Run `php artisan config:clear`

---

## Security Notes

- Never commit your `.env` file to version control
- Use HTTPS in production
- Regularly rotate your OAuth secrets
- Validate and sanitize all user input
- Keep Laravel and dependencies up to date

---

## License

This project is open-source and available under the MIT License.

## Support

For issues or questions:
- Laravel Socialite: https://laravel.com/docs/socialite
- SocialiteProviders: https://socialiteproviders.com/

---

**Happy Coding! 🚀**
