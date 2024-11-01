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
// The importer class
if (!class_exists("WPPtViewerImporter")) {

class WPPtViewerImporter {	
	var $examined_posts = 0;
	var $converted_tags = 0;
	
	/**
	* Constructor
	*/
	function WPPtViewerImporter() {
	}
	
	/**
	* Convert old style tags to new style shortcode
	*/
	function convert_old_tags() {
		global $wpdb;
		
		// For each post
		//--
		$ids = $wpdb->get_col('select ID from ' . $wpdb->posts);
		foreach ($ids as $id) {
			$this->examined_posts++;
			$post = wp_get_single_post($id);
		
			$old_counter_value = $this->converted_tags;
			
			// See if the post contains old style tags and replace them
			//--
			$post->post_content = preg_replace_callback(
				"!<ptviewer ([^>]*)>(.*?)</ptviewer>!is", 
				array(&$this, 'replace_old_full_tag'), 
				$post->post_content);
				
			$post->post_content = preg_replace_callback(
				"!<ptviewer ([^>]*)/>!is", 
				array(&$this, 'replace_old_short_tag'), 
				$post->post_content);
			
			// Save the post if it has been changed
			//--
			if ($old_counter_value != $this->converted_tags) {
				wp_update_post($post);
			}
		}
	}
	
	/**
	* Replace an old-style comment by a new style comment
	*/
	function replace_old_full_tag($match) {
		$this->converted_tags++;
		$tag_params = $match[1];
		$tag_content = (count($match)>=2 ? $match[2] : '');		
		return '[ptviewer ' . $tag_params . ']' . $tag_content . '[/ptviewer]';
	}
	
	/**
	* Replace an old-style comment by a new style comment
	*/
	function replace_old_short_tag($match) {
		$this->converted_tags++;
		$tag_params = $match[1];
		return '[ptviewer ' . $tag_params . '/]';
	}
	
} // class WPPtViewerPlugin

} // if (!class_exists("WPPtViewerPlugin"))
//############################################################################

?>