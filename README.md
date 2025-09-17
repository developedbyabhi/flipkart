# Flipkart Price Tracker

A comprehensive Laravel 11 application that tracks product prices on Flipkart and sends email notifications when prices drop.

## Features

- **Product Management**: Add Flipkart product URLs and automatically scrape product details
- **Price Tracking**: Store complete price history for all tracked products
- **Email Notifications**: Automatic email alerts when prices drop
- **Interactive Dashboard**: Beautiful UI with Chart.js price history graphs
- **Automated Monitoring**: Scheduled price checks every minute
- **Responsive Design**: Modern, mobile-friendly interface with Bootstrap

## Requirements

- PHP 8.1 or higher
- Composer
- SQLite (or MySQL/PostgreSQL)
- Node.js (for frontend assets)

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd flipkart-price-tracker
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   - For SQLite (default):
     ```bash
     touch database/database.sqlite
     ```
   - For MySQL, update `.env` with your database credentials

5. **Configure email settings**
   Update `.env` with your SMTP settings:
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=your-smtp-host
   MAIL_PORT=587
   MAIL_USERNAME=your-email@example.com
   MAIL_PASSWORD=your-password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=your-email@example.com
   NOTIFICATION_EMAIL=admin@example.com
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Start the application**
   ```bash
   php artisan serve
   ```

## Usage

### Adding Products

1. Visit the dashboard at `http://localhost:8000`
2. Enter a Flipkart product URL in the form
3. Click "Add Product" to start tracking

### Price Monitoring

The application automatically checks prices every minute using Laravel's scheduler. To enable this:

1. **Add to system cron** (Linux/Mac):
   ```bash
   crontab -e
   ```
   Add this line:
   ```
   * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
   ```

2. **Manual price check**:
   ```bash
   php artisan prices:check
   ```

### Email Notifications

When a price drop is detected:
- An email is sent to the address specified in `NOTIFICATION_EMAIL`
- The email includes product details, old price, new price, and savings amount
- A direct link to the product on Flipkart is provided

## Database Schema

### Products Table
- `id` - Primary key
- `flipkart_url` - Unique product URL
- `name` - Product name
- `image` - Product image URL
- `current_price` - Latest price
- `timestamps` - Created/updated timestamps

### Price Histories Table
- `id` - Primary key
- `product_id` - Foreign key to products
- `price` - Historical price
- `timestamps` - Price check timestamp

## Architecture

### Models
- **Product**: Represents tracked products with price history relationship
- **PriceHistory**: Stores historical price data for products

### Services
- **ScraperService**: Handles web scraping of Flipkart product pages using Guzzle and Symfony DomCrawler

### Controllers
- **ProductController**: Manages product CRUD operations and dashboard display

### Commands
- **CheckPrices**: Console command for automated price checking and notifications

### Mail
- **PriceDropNotification**: Mailable class for price drop email alerts

## Customization

### Scraping Selectors

The scraper uses CSS selectors to extract product information. If Flipkart changes their HTML structure, update the selectors in `app/Services/ScraperService.php`:

```php
$title = $crawler->filter('h1')->text();
$price = $crawler->filter('._30jeq3._16Jk6d')->text();
$image = $crawler->filter('._396cs4._2amPTt._3qGmMb')->attr('src');
```

### Scheduling Frequency

To change the price check frequency, modify `app/Console/Kernel.php`:

```php
// Check every 5 minutes
$schedule->command('prices:check')->everyFiveMinutes();

// Check hourly
$schedule->command('prices:check')->hourly();

// Check daily at 9 AM
$schedule->command('prices:check')->dailyAt('09:00');
```

### Email Template

Customize the email template in `resources/views/emails/price-drop.blade.php` to match your branding.

## Production Deployment

1. **Optimize for production**:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   composer install --optimize-autoloader --no-dev
   ```

2. **Set up proper cron job**:
   ```bash
   * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
   ```

3. **Configure web server** (Nginx/Apache) to serve the `public` directory

4. **Set up SSL certificate** for secure email transmission

## Troubleshooting

### Common Issues

1. **Scraping fails**: Flipkart may have changed their HTML structure. Update selectors in ScraperService.

2. **Emails not sending**: Check SMTP configuration and ensure the mail server is accessible.

3. **Scheduler not running**: Verify cron job is properly configured and the web server user has necessary permissions.

4. **Database connection errors**: Ensure database file exists (SQLite) or credentials are correct (MySQL).

### Debugging

Enable debug mode in `.env`:
```env
APP_DEBUG=true
LOG_LEVEL=debug
```

Check logs in `storage/logs/laravel.log` for detailed error information.

## Security Considerations

- Never commit `.env` file to version control
- Use strong database passwords in production
- Implement rate limiting for web scraping to avoid being blocked
- Consider using a VPN or proxy rotation for large-scale scraping
- Validate and sanitize all user inputs

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## License

This project is open-source software licensed under the MIT license.

## Support

For issues and questions:
1. Check the troubleshooting section
2. Review Laravel documentation
3. Create an issue in the repository

---

**Note**: This application is for educational purposes. Please respect Flipkart's robots.txt and terms of service when scraping their website.

