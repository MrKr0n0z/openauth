Laravel OAuth 2.0 Inicio de Sesión Social
Una aplicación completa de Laravel 11+ que implementa autenticación social con OAuth 2.0 para Discord, Spotify, Twitch y X (Twitter) usando Laravel Socialite y SocialiteProviders.
Características

Integración OAuth con Discord
Integración OAuth con Spotify
Integración OAuth con Twitch
Integración OAuth con X/Twitter
Gestión segura de sesiones
Perfil de usuario con soporte de avatar
Interfaz responsiva con Tailwind CSS
Soporte para bases de datos SQLite/MySQL
Despliegue sencillo

Inicio Rápido
Requisitos previos

PHP 8.2+
Composer
MySQL o SQLite
Credenciales OAuth de Discord, Spotify, Twitch y X/Twitter

Instalación
bash# Clonar el repositorio
git clone https://github.com/yourusername/laravel-oauth-social-login.git
cd laravel-oauth-social-login

# Instalar dependencias
composer install

# Instalar paquetes de Socialite
composer require laravel/socialite
composer require socialiteproviders/discord socialiteproviders/spotify
composer require socialiteproviders/twitch socialiteproviders/twitter

# Configurar el entorno
cp .env.example .env
php artisan key:generate

# Configurar la base de datos (ejemplo con SQLite)
touch database/database.sqlite

# Ejecutar migraciones
php artisan migrate

# Iniciar el servidor
php artisan serve
Visita http://localhost:8000 para ver la aplicación.
Documentación

INSTALLATION.md - Instrucciones detalladas de instalación
OAUTH_SETUP.md - Guías paso a paso para configurar cada proveedor OAuth

Configuración
Variables de entorno
Agrega esto a tu archivo .env:
env# Discord
DISCORD_CLIENT_ID=tu_client_id
DISCORD_CLIENT_SECRET=tu_client_secret

# Spotify
SPOTIFY_CLIENT_ID=tu_client_id
SPOTIFY_CLIENT_SECRET=tu_client_secret

# Twitch
TWITCH_CLIENT_ID=tu_client_id
TWITCH_CLIENT_SECRET=tu_client_secret

# X/Twitter
X_CLIENT_ID=tu_client_id
X_CLIENT_SECRET=tu_client_secret
```

## Rutas

| Método | URI | Descripción |
|--------|-----|-------------|
| GET | `/` | Página de inicio con botones de acceso |
| GET | `/auth/{provider}/redirect` | Redirige al proveedor OAuth |
| GET | `/auth/{provider}/callback` | Maneja el callback OAuth |
| POST | `/logout` | Cerrar sesión |
| GET | `/dashboard` | Panel de usuario (protegido) |

**Proveedores soportados:** `discord`, `spotify`, `twitch`, `x-twitter`

## Estructura del proyecto
```
app/
├── Http/Controllers/AuthController.php    # Lógica de autenticación OAuth
├── Models/User.php                        # Modelo de usuario con campos OAuth
└── Providers/AppServiceProvider.php       # Listeners de eventos de Socialite

config/services.php                        # Configuraciones de proveedores OAuth

database/migrations/
└── 0001_01_01_000000_create_users_table.php  # Migración de la tabla de usuarios

resources/views/
├── welcome.blade.php                      # Página de inicio de sesión
└── dashboard.blade.php                    # Panel de usuario

routes/web.php                             # Rutas de la aplicación
Esquema de base de datos
La tabla users incluye:
phpid                      - Clave primaria
name                    - Nombre del usuario
email                   - Correo electrónico (nullable)
avatar                  - URL de foto de perfil (nullable)
provider                - Proveedor OAuth (discord/spotify/twitch/x-twitter)
provider_id             - ID del usuario en el proveedor
provider_token          - Token de acceso (500 caracteres, nullable)
provider_refresh_token  - Token de actualización (500 caracteres, nullable)
created_at, updated_at  - Marcas de tiempo
Restricción única: (provider, provider_id) - Cada ID de proveedor es único por proveedor
Seguridad

Tokens OAuth almacenados de forma segura en la base de datos
Protección CSRF habilitada
Gestión de sesiones con la seguridad integrada de Laravel
El campo de contraseña es nullable (autenticación solo por OAuth)
Variables de entorno para datos sensibles

Despliegue
Lista de verificación para producción

Establecer APP_ENV=production en .env
Actualizar APP_URL con tu dominio de producción
Usar HTTPS (requerido por los proveedores OAuth)
Actualizar las URIs de redireccionamiento en los paneles de cada proveedor
Establecer un APP_KEY seguro
Configurar las credenciales correctas de la base de datos
Ejecutar php artisan config:cache
Ejecutar php artisan route:cache

Actualizar las URLs de callback OAuth
Asegúrate de actualizar las URIs de redireccionamiento en el panel de cada proveedor:

Discord: https://tudominio.com/auth/discord/callback
Spotify: https://tudominio.com/auth/spotify/callback
Twitch: https://tudominio.com/auth/twitch/callback
X/Twitter: https://tudominio.com/auth/x-twitter/callback

Contribuciones
Las contribuciones son bienvenidas. No dudes en enviar un Pull Request.
Licencia
Este proyecto es de código abierto y está disponible bajo la Licencia MIT.
Agradecimientos

Laravel
Laravel Socialite
SocialiteProviders
Tailwind CSS

Soporte
Para preguntas o problemas:

Abre un issue en GitHub
Consulta OAUTH_SETUP.md para ayuda específica de cada proveedor
Visita la Documentación de Laravel Socialite