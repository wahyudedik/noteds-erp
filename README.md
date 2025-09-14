# 🏢 ERP System - WorkDo Dash

<p align="center">
<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## 📋 About ERP System

**WorkDo Dash ERP** adalah sistem Enterprise Resource Planning (ERP) yang dibangun dengan Laravel 11. Sistem ini menyediakan fitur lengkap untuk manajemen bisnis termasuk:

- 📊 **Dashboard & Analytics** - Monitoring performa bisnis
- 👥 **User Management** - Manajemen pengguna dengan role-based access
- 💰 **Invoice Management** - Sistem faktur lengkap
- 🛒 **Purchase Management** - Manajemen pembelian
- 📋 **Proposal System** - Sistem proposal bisnis
- 🏪 **Warehouse Management** - Manajemen gudang
- 💳 **Payment Gateway Integration** - Multiple payment gateways
- 🌐 **Multi-language Support** - Dukungan multi bahasa
- 📧 **Email Templates** - Template email yang dapat dikustomisasi
- 🔔 **Notification System** - Sistem notifikasi real-time
- 💬 **Chat System** - Sistem chat internal
- 📱 **Responsive Design** - Mobile-friendly interface

## 🚀 Quick Start

### Prerequisites
- PHP 8.2 atau lebih tinggi
- Composer
- MySQL/MariaDB
- Node.js & NPM
- Git

## 🖥️ Installation on VPS

### 1. Server Requirements

**Minimum Requirements:**
- Ubuntu 20.04 LTS atau lebih tinggi
- 2GB RAM (4GB recommended)
- 20GB Storage
- PHP 8.2+
- MySQL 8.0+ atau MariaDB 10.4+
- Nginx atau Apache
- SSL Certificate (Let's Encrypt)

### 2. Install Dependencies

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install PHP 8.2 and extensions
sudo apt install -y software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt update
sudo apt install -y php8.2 php8.2-cli php8.2-fpm php8.2-mysql php8.2-xml php8.2-curl php8.2-zip php8.2-mbstring php8.2-gd php8.2-bcmath php8.2-intl

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js & NPM
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs

# Install MySQL
sudo apt install -y mysql-server
sudo mysql_secure_installation

# Install Nginx
sudo apt install -y nginx
```

### 3. Clone and Setup Project

```bash
# Clone repository
cd /var/www
sudo git clone https://github.com/yourusername/erp-system.git
sudo chown -R www-data:www-data erp-system
cd erp-system

# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Install Node dependencies and build assets
npm install
npm run build

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Configuration

```bash
# Create database
sudo mysql -u root -p
```

```sql
CREATE DATABASE erp_system;
CREATE USER 'erp_user'@'localhost' IDENTIFIED BY 'strong_password_here';
GRANT ALL PRIVILEGES ON erp_system.* TO 'erp_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

**Update `.env` file:**
```env
APP_NAME="ERP System"
APP_ENV=production
APP_KEY=base64:your_generated_key_here
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=erp_system
DB_USERNAME=erp_user
DB_PASSWORD=strong_password_here

# Email Configuration
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"

# Cache & Session
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Redis Configuration
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### 5. Run Migrations and Seeders

```bash
# Run database migrations
php artisan migrate --force

# Seed initial data
php artisan db:seed --force

# Create storage symlink
php artisan storage:link

# Set proper permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### 6. Nginx Configuration

Create `/etc/nginx/sites-available/erp-system`:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/erp-system/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

```bash
# Enable site
sudo ln -s /etc/nginx/sites-available/erp-system /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### 7. SSL Certificate (Let's Encrypt)

```bash
# Install Certbot
sudo apt install -y certbot python3-certbot-nginx

# Get SSL certificate
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com

# Auto-renewal
sudo crontab -e
# Add: 0 12 * * * /usr/bin/certbot renew --quiet
```

### 8. Setup Cron Jobs

```bash
# Edit crontab
sudo crontab -e

# Add Laravel scheduler
* * * * * cd /var/www/erp-system && php artisan schedule:run >> /dev/null 2>&1
```

### 9. Install Redis (Optional but Recommended)

```bash
# Install Redis
sudo apt install -y redis-server

# Configure Redis
sudo nano /etc/redis/redis.conf
# Set: supervised systemd

# Start Redis
sudo systemctl enable redis-server
sudo systemctl start redis-server
```

### 10. Performance Optimization

```bash
# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set up log rotation
sudo nano /etc/logrotate.d/laravel
```

Add to `/etc/logrotate.d/laravel`:
```
/var/www/erp-system/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    notifempty
    create 644 www-data www-data
}
```

### 11. Security Hardening

```bash
# Set proper file permissions
sudo find /var/www/erp-system -type f -exec chmod 644 {} \;
sudo find /var/www/erp-system -type d -exec chmod 755 {} \;
sudo chmod -R 775 /var/www/erp-system/storage
sudo chmod -R 775 /var/www/erp-system/bootstrap/cache

# Secure .env file
sudo chmod 600 /var/www/erp-system/.env

# Install fail2ban
sudo apt install -y fail2ban
sudo systemctl enable fail2ban
sudo systemctl start fail2ban
```

### 12. Backup Strategy

```bash
# Create backup script
sudo nano /usr/local/bin/backup-erp.sh
```

```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backup/erp-system"
PROJECT_DIR="/var/www/erp-system"

mkdir -p $BACKUP_DIR

# Database backup
mysqldump -u erp_user -p'your_password' erp_system > $BACKUP_DIR/database_$DATE.sql

# Files backup
tar -czf $BACKUP_DIR/files_$DATE.tar.gz -C $PROJECT_DIR .

# Keep only last 7 days
find $BACKUP_DIR -name "*.sql" -mtime +7 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete
```

```bash
# Make executable
sudo chmod +x /usr/local/bin/backup-erp.sh

# Add to crontab (daily backup at 2 AM)
sudo crontab -e
# Add: 0 2 * * * /usr/local/bin/backup-erp.sh
```

## 🔧 Local Development

### Installation

```bash
# Clone repository
git clone https://github.com/yourusername/erp-system.git
cd erp-system

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate
php artisan db:seed

# Build assets
npm run dev

# Start development server
php artisan serve
```

### Default Login Credentials

- **Super Admin:** `superadmin@example.com` / `SecureAdminPassword123!@#`
- **Company:** `company@example.com` / `SecurePassword123!@#`

> ⚠️ **Important:** Change these passwords immediately after installation!

## 🛠️ Troubleshooting

### Common Issues

**1. Images not loading after migration:**
```bash
# Recreate storage symlink
php artisan storage:link

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

**2. Permission issues:**
```bash
# Fix permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

**3. Database connection issues:**
```bash
# Check database configuration
php artisan config:show database

# Test database connection
php artisan tinker
# Then run: DB::connection()->getPdo();
```

## 📚 Documentation

- [Laravel Documentation](https://laravel.com/docs)
- [Laravel Bootcamp](https://bootcamp.laravel.com)
- [Laracasts](https://laracasts.com)

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 🔒 Security

If you discover a security vulnerability, please send an e-mail to the maintainer. All security vulnerabilities will be promptly addressed.

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🙏 Acknowledgments

- [Laravel Framework](https://laravel.com)
- [WorkDo Team](https://workdo.io)
- All contributors and users

---

**Made with ❤️ using Laravel Framework**
