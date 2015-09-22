<?php
/**
 * IG3JS Wordpress Plugin
 *
 * @package   ig3js-wordpress-plugin
 * @author    Oliver Ong <tefiri@gmail.com>
 * @license   GPL-2.0+
 * @link      http://zolphe.com
 * @copyright 10-10-2014 Zolphe
 */

/**
 * IG3JS Wordpress Plugin class.
 *
 * @package IG3JSWordpressPlugin
 * @author  Oliver Ong <tefiri@gmail.com>
 */
class IG3JSWordpressPlugin{
	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	protected $version = "1.0.0";

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = "ig3js-wordpress-plugin";

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action("init", array($this, "load_plugin_textdomain"));

		// Add the options page and menu item.
		add_action("admin_menu", array($this, "add_plugin_admin_menu"));

		// Load admin style sheet and JavaScript.
		add_action("admin_enqueue_scripts", array($this, "enqueue_admin_styles"));
		add_action("admin_enqueue_scripts", array($this, "enqueue_admin_scripts"));

		// Load public-facing style sheet and JavaScript.
		add_action("wp_enqueue_scripts", array($this, "enqueue_styles"));
		add_action("wp_enqueue_scripts", array($this, "enqueue_scripts"));

		// Define custom functionality. Read more about actions and filters: http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		add_action("TODO", array($this, "action_method_name"));
		add_filter("TODO", array($this, "filter_method_name"));

	}

	public function ig3jsWp( $atts ) {

		if(isset($atts['images'])){

		$img = explode(",",$atts['images']);

			$curWidth = 500;

			if(isset($atts['width'])){
				$curWidth = $atts['width'];
			}
			$curHeight = 500;

			if(isset($atts['height'])){
				$curHeight = $atts['height'];
			}

		?>
			<div class="ig3js-canvas"></div>
			<div class="ig3js-nav">
				<a href="#" class="prev">previous</a>
				<span class="goto"></span>
				<a href="#" class="next">next</a> <br />
			</div>
			<div class="ig3js-perspectives">
				<a href="#" class="defP">default</a>
				<a href="#" class="trP">top right</a>
				<a href="#" class="tlP">top left</a>
			</div>
			<script type='text/javascript'>
				jQuery(document).ready(function($){
					var box = $('.ig3js-canvas').ig3js({
						manifest: [
							<?php

							$cnt = 0;

							foreach($img as $imgItem){
								$cnt++;
								?>
								{src:"<?php echo $imgItem; ?>", id:"image<?php echo $cnt; ?>"},
								<?php
							}

							?>
						],
						imagePath: '',
						alphaBackground: true,
						onNavigateComplete: function(obj){
							//     console.log("navigation complete");
							//     console.log(obj);
						},
						canvasWindow:{
							defaultWidth: <?php echo $curWidth; ?>,
							defaultHeight: <?php echo $curHeight; ?>
						}
					});
					$(".ig3js-nav .next").click(function(){
						box.navigate.next();
						return false;
					});

					$(".ig3js-nav .prev").click(function(){
						box.navigate.prev();
						return false;
					});

					$(".ig3js-perspectives .defP").click(function(){
						box.perspective.default();
						return false;
					});

					$(".ig3js-perspectives .trP").click(function(){
						box.perspective.topRight();
						return false;
					});

					$(".ig3js-perspectives .tlP").click(function(){
						box.perspective.topLeft();
						return false;
					});

					for(count=1; count<=<?php echo count($img); ?>; count++){
						$(".ig3js-nav .goto").append('<a href="#" class="goto'+count+'" pos="'+(count-1)+'"> '+count+' </a>');
						$(".ig3js-nav .goto"+count).click(function(){
							box.navigate.goTo($(this).attr("pos"));
							return false;
						});
					}
				});
			</script>
			<?php
		}
		return "";
	}


	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn"t been set, set it now.
		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function activate($network_wide) {
		// TODO: Define activation functionality here
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */
	public static function deactivate($network_wide) {
		// TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters("plugin_locale", get_locale(), $domain);

		load_textdomain($domain, WP_LANG_DIR . "/" . $domain . "/" . $domain . "-" . $locale . ".mo");
		load_plugin_textdomain($domain, false, dirname(plugin_basename(__FILE__)) . "/lang/");
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		if (!isset($this->plugin_screen_hook_suffix)) {
			return;
		}

		$screen = get_current_screen();
		if ($screen->id == $this->plugin_screen_hook_suffix) {
			wp_enqueue_style($this->plugin_slug . "-admin-styles", plugins_url("css/admin.css", __FILE__), array(),
				$this->version);
		}

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		if (!isset($this->plugin_screen_hook_suffix)) {
			return;
		}

		$screen = get_current_screen();
		if ($screen->id == $this->plugin_screen_hook_suffix) {
			wp_enqueue_script($this->plugin_slug . "-admin-script", plugins_url("js/ig3js-wordpress-plugin-admin.js", __FILE__),
				array("jquery"), $this->version);
		}

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style($this->plugin_slug . "-plugin-styles", plugins_url("css/image-gallery-three.css", __FILE__), array(),
			$this->version);
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script($this->plugin_slug . "-plugin-script-threejs", '//cdnjs.cloudflare.com/ajax/libs/three.js/r58/three.min.js', array("jquery"),
			$this->version);
        wp_enqueue_script($this->plugin_slug . "-plugin-script-assets", plugins_url("js/assets.min.js", __FILE__), array("jquery"),
            $this->version);
		wp_enqueue_script($this->plugin_slug . "-plugin-script-preloadjs", '//cdnjs.cloudflare.com/ajax/libs/PreloadJS/0.3.1/preloadjs.min.js', array("jquery"),
			$this->version);
		wp_enqueue_script($this->plugin_slug . "-plugin-script-tweenmax", '//cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js', array("jquery"),
			$this->version);
		wp_enqueue_script($this->plugin_slug . "-plugin-script-stats", '//cdnjs.cloudflare.com/ajax/libs/stats.js/r11/Stats.js', array("jquery"),
			$this->version);
        wp_enqueue_script($this->plugin_slug . "-plugin-script-ig3js", plugins_url("js/image-gallery-three.min.js", __FILE__), array("jquery"),
            $this->version);
		wp_enqueue_script($this->plugin_slug . "-plugin-script-ig3jsp", plugins_url("js/ig3js-wordpress-plugin.js", __FILE__), array("jquery"),
			$this->version);
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {
		$this->plugin_screen_hook_suffix = add_plugins_page(__("IG3JS Wordpress Plugin - Administration", $this->plugin_slug),
			__("IG3JS Wordpress Plugin", $this->plugin_slug), "read", $this->plugin_slug, array($this, "display_plugin_admin_page"));
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once("views/admin.php");
	}

	/**
	 * NOTE:  Actions are points in the execution of a page or process
	 *        lifecycle that WordPress fires.
	 *
	 *        WordPress Actions: http://codex.wordpress.org/Plugin_API#Actions
	 *        Action Reference:  http://codex.wordpress.org/Plugin_API/Action_Reference
	 *
	 * @since    1.0.0
	 */
	public function action_method_name() {
		// TODO: Define your action hook callback here

	}


	/**
	 * NOTE:  Filters are points of execution in which WordPress modifies data
	 *        before saving it or sending it to the browser.
	 *
	 *        WordPress Filters: http://codex.wordpress.org/Plugin_API#Filters
	 *        Filter Reference:  http://codex.wordpress.org/Plugin_API/Filter_Reference
	 *
	 * @since    1.0.0
	 */
	public function filter_method_name() {
		// TODO: Define your filter hook callback here
	}
}

add_shortcode( 'IG3JS', array( 'IG3JSWordpressPlugin', 'ig3jsWp' ) );