<?php
/**
 * Default configuration settings for Tumblr Feed module.
 *
 * You should not put your own configurations here; use your
 * mysite/_config.php file
 *
 * @package tumblrfeed
 */

#SS_Cache::add_backend('cache.tumblr.api', 'File', array('cache_dir' => TEMP_FOLDER . DIRECTORY_SEPARATOR . 'cache'));
#SS_Cache::set_cache_lifetime('cache.tumblr.api', 1800, 10);
#SS_Cache::pick_backend('cache.tumblr.api', 'any', 10);

Object::add_extension('SiteConfig', 'Tumblr_SiteConfig_Extension');