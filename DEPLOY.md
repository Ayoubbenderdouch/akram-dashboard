# Laravel Cloud Deploy Instructions

## Deploy Commands for Laravel Cloud

Use these commands in your Laravel Cloud project settings:

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan storage:link
php artisan db:seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Note**: The seeder now uses `firstOrCreate()` to prevent duplicate user errors on redeployment.

## Important Notes

1. **Storage Link**: The `php artisan storage:link` command is crucial for image uploads to work
2. **Database Seeding**: First deployment should use `php artisan migrate:fresh --seed --force`
3. **Subsequent Deployments**: Use `php artisan migrate --force` instead of `migrate:fresh`

## How to Update Deploy Commands in Laravel Cloud

1. Go to: https://cloud.laravel.com/ayoub-benderdouch/akram-dashboard-2/main
2. Click on **"Commands"** in the sidebar
3. Update the deploy script with the commands above
4. Save changes
5. Go to **"Deployments"** and click **"Redeploy"**

## Admin Login Credentials

After deployment, login to the dashboard:

- **URL**: https://akram-dashboard-main-jotwqj.laravel.cloud/login
- **Email**: admin@akram.dz
- **Password**: Admin@2025

## Image Upload Fix

If product images don't show:

1. Ensure `php artisan storage:link` is in deploy commands
2. Check that `/storage/products` directory exists
3. Verify public disk configuration in `config/filesystems.php`

## Troubleshooting

### Images not displaying after upload
- Run `php artisan storage:link` manually via SSH or add to deploy commands
- Check file permissions on `storage/app/public` directory

### Database errors on deployment
- First time: Use `migrate:fresh --seed`
- Updates: Use `migrate` only

### Login not working
- Ensure seeders ran: `php artisan db:seed --force`
- Check database has users table populated
