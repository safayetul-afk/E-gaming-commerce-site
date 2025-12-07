# Overdue Game Notification & User Ban System (Laravel Edition)

This document explains the overdue game tracking, notification system, and user ban functionality as implemented in the **Gaming Store Laravel application**.

## Features Overview

### 1. Overdue Game Tracking
- Automatically detects games that are past their return date
- Marks games as overdue in the database
- Sends immediate notifications to borrowers using Laravel's notification system
- Alerts admins about overdue users

### 2. User Notification System
- **Borrowers**: Receive warnings about overdue games
- **Admins**: Get notified about users with overdue games
- **Real-time**: Notifications update instantly in the dashboard
- **Persistent**: Notifications are stored and can be marked as read

### 3. Admin User Management
- View all users and their status
- See users with overdue games highlighted
- Ban users for repeated violations
- Unban users when appropriate
- View admin-specific notifications

### 4. User Ban System
- Admins can ban users for overdue games or other violations
- Banned users cannot log in or access the platform
- Ban reasons are recorded and tracked
- Users can be unbanned by admins

## Database Changes

### New Fields Added

#### users Table
- `is_banned` (boolean): Whether the user is banned
- `banned_at` (datetime): When the user was banned
- `banned_by` (unsignedBigInteger): Admin ID who banned the user
- `ban_reason` (text): Reason for the ban

#### game_lendings Table
- `is_overdue` (boolean): Whether the game is overdue
- `overdue_notification_sent` (boolean): Whether overdue notification was sent

#### notifications Table
- `notification_type` (string): Type of notification ('overdue', 'admin', 'general')

#### admin_notifications Table
- Stores admin-specific notifications
- Links to related users when applicable
- Tracks read/unread status

## How It Works

### 1. Automatic Overdue Detection
- A Laravel service or job (e.g. scheduled task or observer) checks for overdue games.
- This can be triggered via a scheduler (`php artisan schedule:run`) or via middleware on user activity.

### 2. Overdue Check Process
1. Finds games past their return date
2. Marks them as overdue
3. Sends notifications to borrowers (using Laravel events/notifications)
4. Alerts admins about overdue users
5. Updates database flags

### 3. Notification Flow
```
Game becomes overdue → Borrower notification + Admin notification
↓
Borrower sees warning on lend_games page
↓
Admin sees overdue user in admin panel
↓
Admin can ban user if necessary
```

## Setup Instructions

### 1. Run Database Migrations
```bash
php artisan migrate
```

### 2. Restart Application
The new functionality is instantly available after migration and code deployment.

### 3. Test the System
1. Create a game lending with a short duration (1 day) using the web UI or Laravel tinker
2. Wait for it to become overdue or manually set it for testing
3. Check notifications for both borrower and admin
4. Test ban/unban functionality in the admin panel

## Admin Features

### User Management (`/admin/users`)
- **Overview**: See all users and their status
- **Overdue Users**: Highlighted section showing users with overdue games
- **Ban Actions**: Ban/unban users with reason tracking
- **Overdue Check**: Manual button to check for overdue games

### Admin Notifications (`/admin/notifications`)
- **System Alerts**: Overdue user notifications
- **Read Status**: Mark notifications as read
- **User Context**: See which user each notification relates to

### Quick Actions
- **Check Overdue**: Manually trigger overdue detection
- **Manage Users**: Direct access to user management
- **View Notifications**: Access admin notification center

## User Experience

### For Regular Users
- **Notifications Page**: View all notifications (`/notifications`)
- **Overdue Warnings**: Prominent warnings on lend_games page
- **Clear Notifications**: Mark individual or all notifications as read

### For Borrowers with Overdue Games
- **Immediate Warning**: Flash message when overdue
- **Persistent Alert**: Warning banner on lend_games page
- **Notification**: Stored notification about overdue status

## API & Web Routes

### Admin Routes (web or API)
- `GET /admin/users` - User management interface
- `POST /admin/ban-user/{user}` - Ban a user
- `POST /admin/unban-user/{user}` - Unban a user
- `GET /admin/notifications` - Admin notifications
- `POST /admin/notification/{id}/read` - Mark notification as read
- `POST /admin/check-overdue` - Manually check for overdue games

### User Routes
- `GET /notifications` - User notifications
- `POST /notification/{id}/read` - Mark notification as read
- `POST /notifications/clear` - Clear all notifications

### Test and Utility Routes (Development Only)
- `POST /test/create-overdue/{lending}` - Create overdue game for testing

## Configuration

### Automatic Checks
- Overdue checks can be scheduled using Laravel's Task Scheduling (`app/Console/Kernel.php`)
- No additional configuration needed for middleware/service-based checks

### Notification Types
- `overdue`: Game overdue warnings
- `admin`: Administrative actions
- `general`: General system notifications

## Security Features

### User Ban Protection
- Admins cannot ban other admins
- Ban reasons are required and logged
- Banned users cannot access any protected routes (middleware check)
- `is_banned` field and related logic are enforced throughout the app

### Access Control
- Admin routes require admin privileges (via middleware)
- User notifications are user-specific
- Admin notifications are admin-only

## Monitoring and Maintenance

### Regular Tasks
1. **Daily**: Check admin notifications for overdue users
2. **Weekly**: Review banned users and consider unbans
3. **Monthly**: Analyze overdue patterns and adjust policies

### Database Maintenance
- Notifications accumulate over time
- Consider archiving old notifications
- Monitor database size growth

## Troubleshooting

### Common Issues

#### Migration Errors
- Ensure database connection and credentials are correct in `.env`
- Check Laravel version compatibility
- Verify table structure before migration

#### Notifications Not Working
- Confirm overdue game checks are running (scheduler or middleware)
- Verify notification tables exist after migration
- Check user authentication status

#### Ban System Issues
- Ensure `is_banned` field exists in User table
- Confirm middleware protecting routes for banned users
- Check admin privileges setup

### Debug Mode
Enable debug logging to see overdue check operations:
```php
// In config/logging.php, set log level to 'debug'
```

## Future Enhancements

### Potential Improvements
1. **Email Notifications**: Send overdue warnings via email (Laravel notifications/mail)
2. **SMS Alerts**: Text message reminders for overdue games
3. **Automatic Bans**: Auto-ban after multiple overdue incidents
4. **Grace Periods**: Configurable grace periods before overdue
5. **Fine System**: Monetary penalties for overdue games
6. **Escalation**: Progressive warning system

### Integration Ideas
1. **Calendar Integration**: Sync return dates with user calendars
2. **Mobile App**: Push notifications for mobile users
3. **Analytics Dashboard**: Overdue statistics and trends
4. **Automated Reports**: Daily/weekly overdue summaries

## Support

For issues or questions about the overdue system:
1. Check this documentation
2. Review migration output in terminal
3. Check Laravel logs for errors (`storage/logs`)
4. Verify database schema matches expectations

---

**Note**: This system is designed to work seamlessly and securely in a Laravel application. Regular monitoring and maintenance will ensure optimal performance and a good user/admin experience.
