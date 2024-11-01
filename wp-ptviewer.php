<?php
/*
Plugin Name: WP PTViewer
Plugin URI: http://www.marvinlabs.com/products-and-references/wordpress-addons/wp-ptviewer/
Description: A plugin that allows you to easily insert dynamic panoramic pictures inside your posts using ptviewer. You can visit the <a href="options-general.php?page=wp-ptviewer">options page</a> and the <a href="options-general.php?page=wp-ptviewer&view=help">help page</a>. 
Version: 2.0.2
Author: MarvinLabs
Author URI: http://www.marvinlabs.com

    Copyright 2006-2011 MarvinLabs

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

//############################################################################
// Stop direct call
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { 
	die('You are not allowed to call this page directly.'); 
}
//############################################################################

//############################################################################
// plugin directory
define('WP_PTVIEWER_DIR', dirname (__FILE__));	

// i18n plugin domain 
define('WP_PTVIEWER_I18N_DOMAIN', 'wp-ptviewer');

// The options of the plugin
define('WP_PTVIEWER_PLUGIN_OPTIONS', 'wp-ptviewer_plugin_options');	
//############################################################################

//############################################################################
// Include the plugin files
require_once(WP_PTVIEWER_DIR . '/includes/plugin-class.php');
//############################################################################

//############################################################################
// Init the plugin classes
global $wpptv_plugin;

$wpptv_plugin = new WPPtViewerPlugin();
//############################################################################

//############################################################################
// Load the plugin text domain for internationalisation
if (!function_exists('wpptv_init_i18n')) {
	function wpptv_init_i18n() {
		load_plugin_textdomain(WP_PTVIEWER_I18N_DOMAIN, 'wp-content/plugins/wp-ptviewer');
	} // function wpptv_init_i18n()

	wpptv_init_i18n();
} // if (!function_exists('wpptv_init_i18n'))
//############################################################################

//############################################################################
// Add filters and actions
add_shortcode(
	'ptviewer', 
	array(&$wpptv_plugin, 'do_ptviewer_shortcode'));
		
if (is_admin()) {
	add_action(
		'activate_wp-ptviewer/wp-ptviewer.php',
		array(&$wpptv_plugin, 'activate'));
	add_action( 
		'admin_menu', 
		array(&$wpptv_plugin, 'add_admin_menus'));
} else {
	add_action( 
		'wp_head', 
		array(&$wpptv_plugin, 'add_css'));
}
//############################################################################

?>