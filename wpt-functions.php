<?php
/**
 * Author: WP Taxi
 * Author URI: https://wp.taxi
 * Description: A collection of useful functions for your WordPress theme's functions.php.
 * Domain Path:
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Network:
 * Plugin Name: WPT Functions
 * Plugin URI: https://github.com/luisdelcid/wpt-functions
 * Text Domain: wpt-functions
 * Version: 2020.2.23
 *
 */ // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	defined('ABSPATH') or die('No script kiddies please!');

	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	add_action('plugins_loaded', function(){
        if(defined('WPT_Functions') or defined('WPT_Functions_Version')){
            add_action('admin_notices', function(){
				printf('<div class="notice notice-error"><p><strong>WPT Functions</strong> already exists.</p></div>');
			});
		} else {
			define('WPT_Functions', __FILE__);
			define('WPT_Functions_Version', '2020.2.23');
            if(!class_exists('Puc_v4_Factory', false)){
                require_once(plugin_dir_path(WPT_Functions) . 'includes/plugin-update-checker-4.9/plugin-update-checker.php');
            }
			Puc_v4_Factory::buildUpdateChecker('https://github.com/luisdelcid/wpt-functions', WPT_Functions, 'wpt-functions');
            require_once(plugin_dir_path(WPT_Functions) . 'functions.php');
        }
	});

	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
