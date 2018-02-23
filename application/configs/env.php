<?php

/*
 * Database settings
 */
defined('DB_HOST') ||
    define('DB_HOST', getenv('DB_HOST'));
defined('DB_USER') ||
    define('DB_USER', getenv('DB_HOST'));
defined('DB_PASS') ||
    define('DB_PASS', getenv('DB_PASS'));
defined('DB_NAME') ||
    define('DB_NAME', getenv('DB_NAME'));

/**
 * Session settings
 */
defined('SESS_SAVE_PATH') ||
    define('SESS_SAVE_PATH', getenv('SESS_SAVE_PATH') ? getenv('SESS_SAVE_PATH') : ini_get('session.save_path'));

/*
 * SMTP settings
 */
defined('MAIL_TYPE') ||
    define('MAIL_TYPE', getenv('MAIL_TYPE') ? getenv('MAIL_TYPE') : 'smtp');
defined('MAIL_HOST') ||
    define('MAIL_HOST', getenv('MAIL_HOST') ? getenv('MAIL_HOST') : 'localhost');
defined('MAIL_SSL') ||
    define('MAIL_SSL', getenv('MAIL_SSL') ? getenv('MAIL_SSL') : 'tls');
defined('MAIL_PORT') ||
    define('MAIL_PORT', getenv('MAIL_PORT') ? getenv('MAIL_PORT') : 587);
defined('MAIL_AUTH') ||
    define('MAIL_AUTH', getenv('MAIL_AUTH') ? getenv('MAIL_AUTH') : 'login');
defined('MAIL_USER') ||
    define('MAIL_USER', getenv('MAIL_USER') ? getenv('MAIL_USER') : '');
defined('MAIL_PASS') ||
    define('MAIL_PASS', getenv('MAIL_PASS') ? getenv('MAIL_PASS') : '');