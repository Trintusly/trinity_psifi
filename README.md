# Startup Social Platform

## Project Description

This project is a social platform designed for startups and entrepreneurs to connect, share ideas, and collaborate. Users can create profiles, share posts, like and comment on posts, and send messages. The platform also supports startup creation, allowing users to join or manage startups, with roles and other relevant information.

The platform uses Laravel as the backend framework, providing a structured way to manage authentication, database models, and relationships. This project also includes various features such as post sharing, messaging systems, and industry management for startups.

## Project Structure

```plaintext
├── app/
│   └── Models/
│       ├── Comment.php        - Model for handling comments on posts
│       ├── Message.php        - Model for handling messages between users
│       ├── Post.php           - Model for handling posts made by users
│       ├── PostLike.php       - Model for handling likes on posts
│       ├── Startup.php        - Model for handling startup information
│       ├── StartupMember.php  - Model for handling users as members of startups
│       └── User.php           - Model for handling user information and relationships
├── database/
│   └── migrations/           - Migration files for creating tables related to the models (e.g., users, posts, comments, etc.)
├── resources/
│   └── views/                - Blade templates for front-end (views for the user dashboard, posts, profile, etc.)
└── routes/
    └── web.php               - API and web routes for managing various endpoints for posts, comments, messages, startups, etc.
```

## Technologies and Frameworks used

**Backend**: Laravel 12
**Database**: MySQL
**Authentication**: Laravel built-in authentication system
**Relationships**: Eloquent ORM for managing relationships (e.g., hasMany, belongsTo)

## Setup and Run instructions

### Prerequisites

PHP 8.0+ (preferably 8.2)
Composer
MySQL or any supported relational database

### Steps

**1. Clone the repository**

```bash
git clone https://github.com/yourusername/your-repository.git
cd your-repository
```

**2. Install Backend dependencies**

```bash
composer install
```

**3. Setup environment file**

```bash
cp .env.example .env
```

**4. Generate application key**

```bash
php artisan key:generate
```

**5. Run migrations**

```bash
php artisan migrate
```

**6. Run application**

```bash
php artisan serve
```

## Deployment links

**Live Demo:** [Insert link here]

## Deployment Steps

**1. FTP Initial Upload**
Upload all project files to the server using an FTP client.
Ensure the `public` directory is properly uploaded to the correct web root.

**2. Database Setup**

Create a new MySQL database via your hosting provider or CLI.
Set up the correct database credentials in the `.env` file.

**3. Import Database Schema**

Import the database schema using `phpMyAdmin` or via the command line.
You can export the schema from the local environment and import it on the server using `phpMyAdmin`'s Import feature.

**4. Configure Environment**

Copy `.env.example` to `.env` on the server.
Update the `.env` file with your server-specific values.

**5. Install Dependencies**

Run Composer to install PHP dependencies:

```bash
composer install --no-dev --optimize-autoloader
```

**6. Generate Application Key**

Run the following command to generate a secure application key:

```bash
php artisan key:generate
```

**7. Set Permissions**

Ensure proper permissions for the `storage` and `bootstrap/cache` directories:

```bash
chmod -R 775 storage bootstrap/cache
```

**8. Run Migrations**

Run migrations to create the necessary database tables:

```bash
php artisan migrate --force
```

**9. Clear Caches**

Clear any cached configurations, routes, and views:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**10. Set Up Web Server**

Configure the web server apache to serve files from the `public` directory.

**11. Set Up Git Version Control**

Initialize Git and pull the project repository for future updates:

```bash
git init
git remote add origin https://github.com/yourusername/your-repository.git
git pull origin main
```

**12. Create a Custom `.htaccess` File for Laravel**

Ensure you have a custom `.htaccess` file in the `public` directory to properly handle URL routing and redirects for Laravel.

Add the following configuration to your `.htaccess` file:

```apache
# Laravel .htaccess

<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>

# Redirect to the public directory
RewriteCond %{REQUEST_URI} !^/public/
RewriteRule ^(.*)$ /public/$1 [L]

# Handle the Laravel default routing
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^ index.php [L]
</IfModule>
```

This `.htaccess` file ensures that Laravel's routing works properly, even when the application is placed in the root directory or a subdirectory. It also redirects all requests to the `public` directory and handles Laravel's routing by forwarding requests to `index.php`.

**13. Start Application**

Your Laravel application is now live and should be accessible via the configured domain

## Documented Features

**1. User Management**

Sign Up/Sign In: Users can register or log in using basic credentials.
User Profile: Includes fields for Username, Email, Bio.

**2. Startup Profile**

Startup Creation: Users can create and manage startup organizations.
Profile Details: Includes Logo, Name, Description, Industries, and Funding Raised.

Sections:

- Members Section to manage employees

**3. Feed**

Post Creation: Users can create posts with optional image attachments and Markdown formatting.
Interactions: Like, comment, save, and share posts.
Feed Visibility: Public visibility, allowing even anonymous users to view posts.

**5. Messaging**

Allows users to send private messages to others in an email format.

**6. Sharable Profiles and Posts**

User, startup, and post profiles have unique, shareable URLs.

**7. Organization Management**

Users can join startups and have different roles:
Owner: Manages invites and requests.
Editor: Can create posts and manage content.
Viewer: Read-only access.

Members Section: Displays users with their roles and positions.
