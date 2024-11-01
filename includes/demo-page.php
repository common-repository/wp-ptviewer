<?php
/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
The license is also available at http://www.gnu.org/copyleft/gpl.html
*/

//############################################################################
// Stop direct call
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { 
	die('You are not allowed to call this page directly.'); 
}
//############################################################################
?>

<div class="wrap">
<h2><?php _e("WP PT-Viewer", WP_PTVIEWER_I18N_DOMAIN); ?> <?php echo $wpptv_plugin->options['active_version']; ?> - <?php _e("Demo", WP_PTVIEWER_I18N_DOMAIN); ?></h2>

<ul class="subsubsub">
	<li><a href="options-general.php?page=wp-ptviewer" ><?php _e("Options", WP_PTVIEWER_I18N_DOMAIN); ?></a> | </li>
	<li><a href="options-general.php?page=wp-ptviewer&view=help" ><?php _e("Help", WP_PTVIEWER_I18N_DOMAIN); ?></a> | </li>
	<li><?php _e("Demo", WP_PTVIEWER_I18N_DOMAIN); ?> | </li>
	<li><a href="options-general.php?page=wp-ptviewer&view=importer" ><?php _e("Importer", WP_PTVIEWER_I18N_DOMAIN); ?></a> | </li>
	<li><a href="http://www.marvinlabs.com/products-and-references/wordpress-addons/wp-ptviewer/" target="_blank"><?php _e('Plugin\'s home page', WP_PTVIEWER_I18N_DOMAIN); ?></a></li>
</ul>
<br class="clear"/>

<div align="center">
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_xclick" />
		<input type="hidden" name="business" value="vpratfr@yahoo.fr" />
		<input type="hidden" name="item_name" value="Vincent Prat - WordPress Plugin" />
		<input type="hidden" name="no_shipping" value="1" />
		<input type="hidden" name="no_note" value="1" />
		<input type="hidden" name="currency_code" value="EUR" />
		<input type="hidden" name="tax" value="0" />
		<input type="hidden" name="lc" value="<?php _e('EN', WP_PTVIEWER_I18N_DOMAIN); ?>" />
		<input type="hidden" name="bn" value="PP-DonationsBF" />
		<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but04.gif" border="0" name="submit" alt="PayPal" />
		<img alt="" border="0" src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" width="1" height="1" />
	</form>
</div>

<br class="clear"/>

<p><?php _e('The following panorama was created using the tag below. It uses the default values set in the options above for the parameters that are not specified.', WP_PTVIEWER_I18N_DOMAIN); ?></p>

<p>
<code>[ptviewer  <br/>
&nbsp;&nbsp;&nbsp;&nbsp;href="<?php echo get_option('siteurl'); ?>/wp-content/plugins/wp-ptviewer/images/sample_panorama.jpg" <br/>
&nbsp;&nbsp;&nbsp;&nbsp;imagewidth="1000" imageheight="345" <br/>
&nbsp;&nbsp;&nbsp;&nbsp;horizon="105" hfov="228" ]<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</code><?php _e('Sample panorama', WP_PTVIEWER_I18N_DOMAIN); ?> &copy; Vincent Prat 2007<br/>
<code>[/ptviewer]</code><br/>
</p>

<p><?php _e('Original image (click on the small-size image to see full-size image):', WP_PTVIEWER_I18N_DOMAIN); ?> </p>
<div align="center">
<a href="<?php echo get_option('siteurl'); ?>/wp-content/plugins/wp-ptviewer/images/sample_panorama.jpg" target="_blank">
<img 
	src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/wp-ptviewer/images/sample_panorama_small.jpg" 
	width="700" height="242" 
	alt="<?php _e('Sample panorama', WP_PTVIEWER_I18N_DOMAIN); ?> &copy; Vincent Prat 2007" 
	title="<?php _e('Sample panorama', WP_PTVIEWER_I18N_DOMAIN); ?> &copy; Vincent Prat 2007" />
</a>
</div>

<p><?php _e('Panorama produced:', WP_PTVIEWER_I18N_DOMAIN); ?> </p>
<div align="center">
	<?php 
		echo do_shortcode(
			  '[ptviewer href="' . get_option('siteurl') . '/wp-content/plugins/wp-ptviewer/images/sample_panorama.jpg" '
			. 'imagewidth="1000" imageheight="345" horizon="105" hfov="228" ]'
			. __('Sample panorama', WP_PTVIEWER_I18N_DOMAIN) . ' &copy; Vincent Prat 2007'
			. '[/ptviewer]');
	?>
</div>


</div>
	