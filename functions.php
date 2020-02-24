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

    if(!function_exists('wpt_attachment_guid_to_postid')){
		function wpt_attachment_guid_to_postid($url = ''){
			if($url){
				/** original */
				$post_id = wpt_guid_to_postid($url);
				if($post_id){
					return $post_id;
				}
				/** scaled */
				preg_match('/^(.+)(-scaled)(\.' . substr($url, strrpos($url, '.') + 1) . ')?$/', $url, $matches);
				if($matches){
					$url = $matches[1];
					if(isset($matches[3])){
						$url .= $matches[3];
					}
				}
				/** resized */
				preg_match('/^(.+)(-\d+x\d+)(\.' . substr($url, strrpos($url, '.') + 1) . ')?$/', $url, $matches);
				if($matches){
					$url = $matches[1];
					if(isset($matches[3])){
						$url .= $matches[3];
					}
				}
				$post_id = wpt_guid_to_postid($url);
				if($post_id){
					return $post_id;
				}
				/** edited */
				preg_match('/^(.+)(-e\d+)(\.' . substr($url, strrpos($url, '.') + 1) . ')?$/', $url, $matches);
				if($matches){
					$url = $matches[1];
					if(isset($matches[3])){
						$url .= $matches[3];
					}
				}
				$post_id = wpt_guid_to_postid($url);
				if($post_id){
					return $post_id;
				}
			}
			return 0;
		}
	}

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

    if(!function_exists('wpt_guid_to_postid')){
		function wpt_guid_to_postid($guid = ''){
			if($guid){
				global $wpdb;
				$str = "SELECT ID FROM $wpdb->posts WHERE guid = %s";
				$sql = $wpdb->prepare($str, $guid);
				$post_id = $wpdb->get_var($sql);
				if($post_id){
					return (int) $post_id;
				}
			}
			return 0;
		}
	}

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
