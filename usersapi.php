<?php # -*- coding: utf-8 -*-

/**
 * Plugin name: Users API
 * Plugin URI: https://netlinkler.com
 * Description: Get information from external APIs in WordPress
 * Author: Asela Daskon
 * Author URI: https://netlinkler.com/profile
 * version: 0.1.0
 * License: GPLv2 or later
 * text-domain: users-api
 */

namespace Netlinkler\UsersApi;

if (!class_exists(UsersApi::class) && is_readable(__DIR__.'/vendor/autoload.php')) {
    require_once __DIR__.'/vendor/autoload.php';
}

class_exists(UsersApi::class);