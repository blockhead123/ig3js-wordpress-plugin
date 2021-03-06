<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   ig3js-wordpress-plugin
 * @author    Oliver Ong <tefiri@gmail.com>
 * @license   GPL-2.0+
 * @link      http://zolphe.com
 * @copyright 10-10-2014 Zolphe
 */
?>
<div class="wrap">
	<?php screen_icon(); ?>
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<!-- TODO: Provide markup for your options page here. --><br /><br />
	To use the plugin copy this shortcode and replace the image paths and dimensions. <br /><br />
	[IG3JS images='image path 1,image path 2,image path 3' width='600' height='600']
</div>
