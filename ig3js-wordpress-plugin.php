<?php
/**
 * IG3JS Wordpress Plugin
 *
 * 3D Image Gallery using WebGL Threejs
 *
 * @package   ig3js-wordpress-plugin
 * @author    Oliver Ong <tefiri@gmail.com>
 * @license   GPL-2.0+
 * @link      http://zolphe.com
 * @copyright 10-10-2014 Zolphe
 *
 * @wordpress-plugin
 * Plugin Name: IG3JS Wordpress Plugin
 * Plugin URI:  http://zolphe.com
 * Description: 3D Image Gallery using WebGL Threejs
 * Version:     1.0.0
 * Author:      Oliver Ong
 * Author URI:  http://zolphe.com
 * Text Domain: ig3js-wordpress-plugin-locale
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if (!defined("WPINC")) {
	die;
}

require_once(plugin_dir_path(__FILE__) . "IG3JSWordpressPlugin.php");

// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
register_activation_hook(__FILE__, array("IG3JSWordpressPlugin", "activate"));
register_deactivation_hook(__FILE__, array("IG3JSWordpressPlugin", "deactivate"));

IG3JSWordpressPlugin::get_instance();