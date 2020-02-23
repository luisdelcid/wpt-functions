<?php

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    defined('WPT_Functions') or die('No script kiddies please!');

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    if(!class_exists('WPT_CL', false)){

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    class WPT_CL {

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    //
    // Public
    //
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    public static function config($values = array()){
        $values = shortcode_atts(array(
            'api_key' => '',
            'api_secret' => '',
            'cloud_name' => '',
            'secure' => true
        ), $values);
        if($values['api_key'] and $values['api_secret'] and $values['cloud_name']){
            self::$config = true;
            \Cloudinary::config($values);
        }
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    public static function add_image_size($name = '', $args = array()){
        $name = sanitize_title($name);
        $args = shortcode_atts(array(
            'name' => $name,
            'options' => array(),
        ), $args);
        ksort($args['options']);
        $args['options_md5'] = md5(wpt_base64_urlencode(wp_json_encode($args['options'])));
        self::$image_sizes[$name] = $args;
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    public static function image_downsize_filter($out, $id, $size){
        if(wp_attachment_is_image($id) and is_string($size) and isset(self::$image_sizes[$size]) and self::$config){
            $image = self::image_get_intermediate_size($id, $size);
            if($image){
                return $image;
            }
        }
		return $out;
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    public static function image_size_names_choose_filter($sizes){
        if(self::$image_sizes){
            foreach(self::$image_sizes as $name => $args){
                if(!isset($sizes[$name])){
                    $sizes[$name] = $args['name'];
                }
            }
        }
        return $sizes;
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    public static function init(){
        if(!class_exists('\Cloudinary', false)){
            require_once(plugin_dir_path(WPT_Functions) . 'includes/cloudinary_php-1.16.0/autoload.php');
        }
        add_filter('image_downsize', array(__CLASS__, 'image_downsize_filter'), 10, 3);
        add_filter('image_size_names_choose', array(__CLASS__, 'image_size_names_choose_filter'));
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    //
    // Private
    //
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    private static $config = false, $image_sizes = array();

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    private static function image_get_intermediate_size($id = 0, $size = ''){
        $image_size = self::$image_sizes[$size];
        $image = get_post_meta($id, '_wpt_cl_image_' . $image_size['options_md5'], true);
        if(!$image){
            $image = \Cloudinary\Uploader::upload(get_attached_file($id), $image_size['options']);
            if($image instanceof \Cloudinary\Error){
                return false;
            }
    		update_post_meta($id, '_wpt_cl_image_' . $image_size['options_md5'], $image);
        }
        $url = (isset($image['secure_url']) ? $image['secure_url'] : (isset($image['url']) ? $image['url'] : ''));
        $width = (isset($image['width']) ? $image['width'] : 0);
        $height = (isset($image['height']) ? $image['height'] : 0);
        if(!$url or !$width or !$height){
            return false;
        }
        return array($url, $width, $height, true);
	}

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    WPT_CL::init();

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
