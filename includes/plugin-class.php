<?php
/*  Copyright 2006 Vincent Prat  (email : vpratfr@yahoo.fr)

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
// Some constants 
//############################################################################

//############################################################################
// The plugin class
if (!class_exists("WPPtViewerPlugin")) {

class WPPtViewerPlugin {
	var $current_version = '2.0.2';
	var $options;
	
	/**
	* Constructor
	*/
	function WPPtViewerPlugin() {
		$this->load_options();
	}
	
	/**
	* Function to be called when the plugin is activated
	*/
	function activate() {
		global $enh_links_widget;
		
		$active_version = $this->options['active_version'];
		if (!isset($active_version) || $active_version=='') {
			$active_version = get_option('wp-ptviewer_version');
		}
		
		if ($active_version==$this->current_version) {
			// do nothing
		} else {
			if ($active_version=='') {			
			} else if ($active_version<'2.0.0') {
				$this->options['jar_url'] 		= get_option('wp-ptviewer_jar_url');
				$this->options['default_applet_width'] 	= get_option('wp-ptviewer_default_applet_width');
				$this->options['default_applet_height'] = get_option('wp-ptviewer_default_applet_height');
				$this->options['default_image_path'] 	= get_option('wp-ptviewer_default_image_path');
				$this->options['default_div_class'] 	= get_option('wp-ptviewer_default_div_class');
				
				delete_option('wp-ptviewer_version');
				delete_option('wp-ptviewer_jar_url');
				delete_option('wp-ptviewer_default_applet_width');
				delete_option('wp-ptviewer_default_applet_height');
				delete_option('wp-ptviewer_default_image_path');
				delete_option('wp-ptviewer_default_div_class');
			} 
		}
		
		// Update version number & save new options
		$this->options['active_version'] = $this->current_version;
		$this->save_options();
	}
	
	/**
	* Add the administration menus
	*/
	function add_admin_menus() {
		add_options_page( 
			__('WP PT-Viewer', WP_PTVIEWER_I18N_DOMAIN), 
			__('WP PT-Viewer', WP_PTVIEWER_I18N_DOMAIN), 
			8,
			'wp-ptviewer', 
			array (&$this, 'menu_callback'));
	}
    
	/**
	* Function called on a menu click to display the appropriate view
	*/
	function menu_callback() {   
		$view = $this->get_view_parameter();
		switch ($view) {
		case "demo":
			include_once(dirname(__FILE__) . '/demo-page.php' );
			break;
		case "help":
			include_once(dirname(__FILE__) . '/help-page.php' );
			break;
		case "importer":
			include_once(dirname(__FILE__) . '/import-page.php' );
			break;
		default:
			include_once(dirname(__FILE__) . '/options-page.php' );
		}
	}
        	
	/**
	 * Get the page from the GET or POST values
	 */
	function get_view_parameter() {
		if (isset($_GET['page']) && $_GET['page']=='wp-ptviewer' && isset($_GET['view'])) {
			return $_GET['view'];
		} else if (isset($_GET['page'])) {
			return $_GET['page'];
		} else {
			return $_POST['page'];
		}
	}
	
	/**
	* Add the CSS file to the HEAD section
	*/
	function add_css() {
		echo "<link rel='stylesheet' href='" . get_option('siteurl') . "/wp-content/plugins/wp-ptviewer/css/wp-ptviewer.css' type='text/css' />";
	}
	
	/**
	* Shortcode callback
	*/
	function do_ptviewer_shortcode($atts, $content=null) {	
		$errors = '';
		$output = '';
	
		// Extract attributes
		//--
		extract(shortcode_atts(array(
			'image' => '',
			'href' => '',
			'imagewidth' => '',
			'imageheight' => '',
			'horizon' => '',
			'hfov' => '',
			'width' => $this->options['default_applet_width'],
			'height' => $this->options['default_applet_height'],
			'cssclass' => $this->options['default_div_class'],
			'debug' => 0
		), $atts));
		
		// Start building the output HTML
		//--
		$output .= '<div class="' . $cssclass . '">';

		// Get image url
		//--
		$image_url = '';
		if ($image=='' && $href=='') {
			$errors .= "<strong>" . __("PT Viewer tag error: no image specified in the shortcode.", WP_PTVIEWER_I18N_DOMAIN) . "</strong><br/>";
		} else {
			if ($image!='') {
				$image_url = $this->options['default_image_path'] . $image;
			} else {
				$image_url = $href;
			}
		}
		
		// Check parameters
		//--
		if ($imagewidth=='' || $imageheight=='' || $horizon=='' || $hfov=='') {
			$errors .= "<strong>" . __("PT Viewer tag error: a required parameter has not been provided.", WP_PTVIEWER_I18N_DOMAIN) . "</strong><br/>";
		}
		
		// Compute the applet tag
		//--
		if ($errors=='') {
			$output .= $this->get_applet_html($width, $height, $image_url, $imagewidth, $imageheight, $horizon, $hfov);
		}
		
		// Append the shortcode's content if not null. Allow nested shortcodes.
		//--
		if ($content!=null) {
			$output .= "<div class='caption'>" . do_shortcode($content) . "</div>";
		}
	
		// Append the errors
		//--
		if ($errors!='' || $debug!=0) {
			$output .= '<br/>';
			$output .= '<div class="errors">' . $errors . '</div>';
			
			$output .= '<div class="debug">';
			$output .= "<p>PT Viewer tag debugging (you might have made a typo in your tag or tag parameters): <ul>";	
			$output .= "<li>Applet: " . $this->options['jar_url'] . "</li>";
			$output .= "<li>Image: " . $image_url . "</li>";
			$output .= "<li>Applet width: " . $width . "</li>";
			$output .= "<li>Applet height: " . $height . "</li>";
			$output .= "<li>Image width: " . $imagewidth . "</li>";
			$output .= "<li>Image height: " . $imageheight . "</li>";
			$output .= "<li>Horizon: " . $horizon . "</li>";
			$output .= "<li>Horizontal FOV: " . $hfov . "</li>";
			$output .= "<li>CSS class: " . $cssclass . "</li>";
			$output .= "<li>Content: " . ($content!=null ? $content : 'null')  . "</li>";
			$output .= "</ul></p>";
			$output .= '</div>';
		}
		
		// Close our initial DIV tag and exit
		//--
		$output .= '</div>';
		return $output;
	}

	/** 
	 * Get the html code for the applet
	 */
	function get_applet_html($applet_width, $applet_height, $image_url, $image_width, $image_height, $horizon, $hfov) {								
		// Compute the output parameters
		//--
		$fovPerPixel = $hfov / $image_width;

		$pwidth = (int) (360 / $fovPerPixel);
		$pheight = (int) (180 / $fovPerPixel);

		$x = (int)( ($pwidth - $image_width) / 2 );
		$y = (int)( $pheight / 2 - $horizon );

		$panmin = (int) ((-$image_width / 2) * $fovPerPixel);
		$panmax = (int) (($image_width / 2) * $fovPerPixel);

		$tiltmin = (int) (-($image_height - $horizon) * $fovPerPixel);
		$tiltmax = (int) ($horizon * $fovPerPixel);
		
		// Output the html code
		//--
		$htmlCode = "";
		if ($hfov>100) {
			$htmlCode .= '<applet archive="' . $this->options['jar_url'] . '"'
						. ' width="' . $applet_width . '" height="' . $applet_height . '"'
						. ' code="ptviewer.class" >';
			$htmlCode .= '<param name="roi0"    value="i\'' . $image_url . '\' x' . $x . ' y' . $y . '"></param>';
			$htmlCode .= '<param name="pwidth"  value="' . $pwidth . '"></param>';
			$htmlCode .= '<param name="pheight" value="' . $pheight . '"></param>';
			$htmlCode .= '<param name="panmin"  value="' . $panmin . '"></param>';
			$htmlCode .= '<param name="panmax"  value="' . $panmax . '"></param>';
			$htmlCode .= '<param name="tiltmin" value="' . $tiltmin . '"></param>';
			$htmlCode .= '<param name="tiltmax" value="' . $tiltmax . '"></param>';
			$htmlCode .= '</applet>';
		} else {
			$htmlCode .= '<applet archive="' . $jarUrl . '"'
						. ' width="' . $applet_width . '" height="' . $applet_height . '"'
						. ' code="ptviewer.class" mayscript="true">';
			$htmlCode .= '<param name="applet0" value="{code=ptzoom.class} '
														.'{file=' . $image_url . '} '
														.'{progress=true} '
														.'{fov=' . $hfov . '}"></param>';
			$htmlCode .= '<param name="inits"   value="ptviewer:startApplet(0)"></param>';
			$htmlCode .= '<param name="panmin"  value="' . $panmin . '"></param>';
			$htmlCode .= '<param name="panmax"  value="' . $panmax . '"></param>';
			$htmlCode .= '<param name="tiltmin" value="' . $tiltmin . '"></param>';
			$htmlCode .= '<param name="tiltmax" value="' . $tiltmax . '"></param>';
			$htmlCode .= '</applet>';
		}
		
		return $htmlCode;
}

		
	/**
	* Load the options from database (set default values in case options are not set)
	*/
	function load_options() {
		$this->options = get_option(WP_PTVIEWER_PLUGIN_OPTIONS);
		
		if ( !is_array($this->options) ) {
			$this->options = array(
				'active_version'		=> '',
				'jar_url'				=> (get_option('siteurl') . '/wp-content/plugins/wp-ptviewer/applets/ptviewer.jar'),
				'default_image_path'	=> (get_option('siteurl') . '/wp-content/uploads/'),
				'default_applet_width'	=> '500',
				'default_applet_height'	=> '300',
				'default_div_class'		=> 'ptviewer'
			);
			add_option(WP_PTVIEWER_PLUGIN_OPTIONS, $this->options);
		}
	}
	
	/**
	* Save options to database
	*/
	function save_options() {
		update_option(WP_PTVIEWER_PLUGIN_OPTIONS, $this->options);
	}
	
} // class WPPtViewerPlugin

} // if (!class_exists("WPPtViewerPlugin"))
//############################################################################

?>