<?php

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    defined('WPT_Functions') or die('No script kiddies please!');

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    //
    // Cloudinary
    //
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    function add_wpt_cl_image_size($name = '', $args = array()){
        if(!class_exists('WPT_CL', false)){
            require_once(plugin_dir_path(WPT_Functions) . 'classes/class-wpt-cl.php');
        }
        WPT_CL::add_image_size($name, $args);
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    function wpt_cl_config($values = array()){
        if(!class_exists('WPT_CL', false)){
            require_once(plugin_dir_path(WPT_Functions) . 'classes/class-wpt-cl.php');
        }
        WPT_CL::config($values);
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    //
    // Miscellaneous
    //
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    if(!function_exists('wpt_base64_urldecode')){
		function wpt_base64_urldecode($data = ''){
			return base64_decode(strtr($data, '-_', '+/'));
		}
	}

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    if(!function_exists('wpt_base64_urlencode')){
		function wpt_base64_urlencode($data = ''){
			return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
		}
	}

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
