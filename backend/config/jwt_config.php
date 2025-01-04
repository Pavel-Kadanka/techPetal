<?php
// This should be a long, random string. In production, store this in environment variables
define('JWT_SECRET_KEY', 'your_very_long_random_secret_key_here');
define('JWT_ISSUER', 'your_app_name');
define('JWT_AUDIENCE', 'your_app_users');
define('JWT_EXPIRATION_TIME', 3600); // 1 hour in seconds 