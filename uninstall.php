<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   ig3js-wordpress-plugin
 * @author    Oliver Ong <tefiri@gmail.com>
 * @license   GPL-2.0+
 * @link      http://zolphe.com
 * @copyright 10-10-2014 Zolphe
 */

// If uninstall, not called from WordPress, then exit
if (!defined("WP_UNINSTALL_PLUGIN")) {
	exit;
}

// TODO: Define uninstall functionality here