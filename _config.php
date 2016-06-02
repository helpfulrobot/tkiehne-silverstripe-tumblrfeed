<?php
/**
 * Default configuration settings for Tumblr Feed module.
 *
 * You should not put your own configurations here; use your
 * mysite/_config.php file
 *
 * @package tumblrfeed
 */

SS_Cache::add_backend('tumblr_api_cache', 'File', array('cache_dir' => TEMP_FOLDER . DIRECTORY_SEPARATOR . 'cache'));
SS_Cache::set_cache_lifetime('tumblr_api_cache', 1800, 10);
SS_Cache::pick_backend('tumblr_api_cache', 'any', 10);

Object::add_extension('SiteConfig', 'Tumblr_SiteConfig_Extension');