# SchoolPulse Marketing Website

A complete marketing website for the SchoolPulse school management system, built with PHP 8, MySQL 8, and modern web technologies.

## Features

- **Modern Design**: Clean, professional design with navy and amber color scheme
- **Responsive Layout**: Mobile-first design that works on all devices
- **Lead Generation**: Demo request forms and contact management
- **Admin Dashboard**: Complete admin panel for managing leads, clients, and content
- **Blog System**: Built-in blog for content marketing
- **SEO Optimized**: Clean URLs, meta tags, and structured data

## Tech Stack

- **Backend**: PHP 8.x with PDO
- **Database**: MySQL 8.x
- **Frontend**: HTML5, CSS3 (Custom Properties), Vanilla JavaScript
- **Typography**: Outfit (headings) + Source Serif 4 (body) from Google Fonts

## Installation

1. **Clone/Download** the project files to your web server
2. **Create Database** using the provided `database.sql` file
3. **Configure Database** connection in `includes/db.php`
4. **Set Permissions** for the `assets/uploads/` directory (755)
5. **Access Admin** at `/admin/login.php` (default: admin@schoolpulse.in / admin123)

## Project Structure

```
schoolpulse-marketing/
├── index.php              # Homepage
├── demo.php               # Demo request form
├── features.php           # Features page
├── pricing.php            # Pricing plans
├── contact.php            # Contact form
├── blog.php               # Blog listing
├── admin/                 # Admin panel
│   ├── dashboard.php      # Admin dashboard
│   ├── leads.php          # Demo requests management
│   ├── clients.php        # Client management
│   └── blog.php           # Blog management
├── includes/              # Core PHP files
│   ├── db.php             # Database connection
│   ├── auth.php           # Authentication
│   └── functions.php      # Utility functions
├── assets/                # Static assets
│   ├── css/               # Stylesheets
│   ├── js/                # JavaScript
│   ├── img/               # Images
│   └── uploads/           # User uploads
└── api/                   # AJAX endpoints
    ├── submit-demo.php    # Demo form handler
    └── submit-contact.php # Contact form handler
```

## Configuration

### Database Settings
Edit `includes/db.php` with your database credentials:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'schoolpulse_marketing');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

### Site Settings
Configure site settings through the admin panel at `/admin/settings.php` or directly in the `site_settings` table.

## Default Admin Account

- **Email**: admin@schoolpulse.in
- **Password**: admin123

**Important**: Change the default password immediately after installation.

## Security Features

- PDO prepared statements for all database queries
- Password hashing with bcrypt
- CSRF protection on forms
- Input sanitization and validation
- Session-based authentication
- .htaccess security headers

## Development

### Adding New Pages
1. Create the PHP file in the root directory
2. Include the header and footer templates
3. Add navigation links in `includes/header.php`

### Customizing Design
- Main styles are in `assets/css/style.css`
- Admin styles are in `assets/css/admin.css`
- CSS custom properties are used for theming

### Database Schema
The complete database schema is in `database.sql` with tables for:
- Admin users
- Demo requests
- Contact submissions
- Clients
- Blog posts
- Site settings

## Deployment

1. Upload files to your web server
2. Import `database.sql` into your MySQL database
3. Configure database connection
4. Set up SSL certificate (recommended)
5. Configure email settings for notifications

## Support

For technical support or customization requests, contact the development team.

## License

This project is proprietary software for SchoolPulse. All rights reserved.# saas-marketing-schoolpulse
