# Student Learning and Course Management System (SLCM)

A PHP-based student portal system for managing student information, courses, and academic activities.

## Features

- Student registration and login
- Profile management
- Course management
- Campus placement information
- Club activities
- Event management

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache web server
- mod_rewrite enabled

## Installation

1. Clone the repository to your Apache web directory:
```bash
git clone https://github.com/yourusername/SLCM.git
cd SLCM
```

2. Create a MySQL database and import the schema:
```sql
CREATE DATABASE students_db;
USE students_db;

CREATE TABLE students (
    sid VARCHAR(20) PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    name VARCHAR(100) NOT NULL,
    dob DATE NOT NULL,
    phone_number VARCHAR(15) NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    enrollment_date DATE NOT NULL,
    address TEXT NOT NULL,
    branch VARCHAR(50) NOT NULL,
    section VARCHAR(10) NOT NULL,
    semester INT NOT NULL
);
```

3. Update the database configuration in `config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('DB_NAME', 'students_db');
```

4. Set proper permissions:
```bash
chmod 755 -R /path/to/SLCM
chmod 644 config.php
```

5. Configure Apache:
- Enable mod_rewrite
- Update your virtual host configuration to allow .htaccess overrides
```apache
<Directory /path/to/SLCM>
    AllowOverride All
</Directory>
```

6. Restart Apache:
```bash
sudo service apache2 restart
```

## Security Considerations

1. Always use HTTPS in production
2. Keep PHP and MySQL updated
3. Use strong passwords
4. Regularly backup the database
5. Monitor error logs
6. Keep config.php secure and outside web root if possible

## Directory Structure

```
SLCM/
├── config.php           # Database and app configuration
├── login.php           # Login page
├── register.php        # Registration page
├── dashboard.php       # Main dashboard
├── student.php         # Student profile
├── courses.php         # Course management
├── campusplacement.php # Placement information
├── clubs.php          # Club activities
├── oniros.php         # Events page
├── logout.php         # Logout handler
└── .htaccess          # Apache configuration
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details. 