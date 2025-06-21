# AssetFlow Authentication Setup & Troubleshooting Guide

## ✅ Current Status
Based on our testing, the authentication system is **WORKING CORRECTLY**. All components are functional:

- ✅ Login functionality
- ✅ Registration functionality  
- ✅ Password reset functionality
- ✅ User roles and permissions
- ✅ Session management
- ✅ CSRF protection

## 🔧 Configuration Recommendations

### 1. Mail Configuration for Password Reset

**Current Setting:** Emails are logged to `storage/logs/laravel.log`

**For Development (Current):**
```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@assetflow.test"
MAIL_FROM_NAME="AssetFlow System"
```

**For Production/Better Testing:**
```env
# Option 1: Mailtrap (Recommended for testing)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password

# Option 2: Gmail SMTP
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_gmail@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
```

### 2. Session Configuration
Current configuration is correct for development:
```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
```

## 🚀 How to Use the System

### Test Users (Already Seeded)
1. **Admin User:**
   - Email: `admin@assetflow.test`
   - Password: `password123`
   - Role: Admin (full access)

2. **Regular User:**
   - Email: `user@assetflow.test`
   - Password: `password123`
   - Role: User (limited access)

### Authentication URLs
- Login: `http://localhost:8000/login`
- Register: `http://localhost:8000/register`
- Forgot Password: `http://localhost:8000/forgot-password`

### Password Reset Process
1. Go to forgot password page
2. Enter email address
3. Check `storage/logs/laravel.log` for reset link (when using log mailer)
4. Copy the reset link and open in browser
5. Set new password

## 🛠️ Troubleshooting Common Issues

### Issue 1: "Page Expired" Error
**Cause:** CSRF token mismatch
**Solution:**
```bash
php artisan cache:clear
php artisan config:clear
php artisan session:clear
```

### Issue 2: Login Not Working
**Check:**
1. Verify user exists in database
2. Check password is correct
3. Clear browser cache/cookies
4. Ensure server is running

### Issue 3: Password Reset Email Not Received
**With log mailer (current):**
- Check `storage/logs/laravel.log`
- Search for "reset-password" links

**With SMTP mailer:**
- Check spam folder
- Verify mail configuration
- Check mail service logs

### Issue 4: Registration Validation Errors
**Common causes:**
- Email already exists
- Password too short (minimum 8 characters)
- Password confirmation doesn't match
- Terms not accepted

## 🔍 Debugging Commands

### Check System Status
```bash
php artisan route:list --name=auth
php artisan config:show mail
php artisan config:show session
```

### Clear All Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Test Database Connection
```bash
php artisan tinker
>>> App\Models\User::count()
```

### View Logs
```bash
tail -f storage/logs/laravel.log
```

## 🧪 Testing Authentication

### Manual Testing Steps
1. **Login Test:**
   - Go to `/login`
   - Use `admin@assetflow.test` / `password123`
   - Should redirect to admin dashboard

2. **Registration Test:**
   - Go to `/register`
   - Fill all required fields
   - Should create account and login

3. **Password Reset Test:**
   - Go to `/forgot-password`
   - Enter `admin@assetflow.test`
   - Check logs for reset link

### Automated Testing
Run the authentication test script:
```bash
php test_auth.php
```

## 📋 Security Notes

### Current Security Measures
- CSRF protection on all forms
- Password hashing with bcrypt
- Session regeneration on login
- SQL injection protection via Eloquent ORM
- Input validation and sanitization

### Production Recommendations
1. Use HTTPS in production
2. Set strong session encryption
3. Configure proper mail service
4. Set up rate limiting for authentication
5. Enable email verification for new accounts

## 🎯 Next Steps

1. **For Development:** System is ready to use as-is
2. **For Production:** 
   - Configure proper mail service
   - Set up HTTPS
   - Review security settings
   - Set up monitoring

## 📞 Support

If you encounter any issues not covered in this guide:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Check browser console for JavaScript errors
3. Verify server is running: `php artisan serve`
4. Clear all caches and try again

---

**Status:** ✅ Authentication system is fully functional and ready for use! 