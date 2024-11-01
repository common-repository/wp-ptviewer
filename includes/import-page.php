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

<?php 	
if (isset($_POST['wpptv_import_submit'])) {
	include_once(WP_PTVIEWER_DIR . '/includes/importer-class.php');
	
	$importer = new WPPtViewerImporter();
	$importer->convert_old_tags();
	
	echo '<div id="message" class="updated fade"><p>';
	echo __('Converted successfully old-style &lt;ptviewer&gt; tags to new-style [ptviewer] shortcodes.', WP_PTVIEWER_I18N_DOMAIN) . '<br/>';
	echo sprintf(__('Parsed %s posts where %s old-style tags were found and converted.', WP_PTVIEWER_I18N_DOMAIN), $importer->examined_posts, $importer->converted_tags) . '<br/>';
	echo '</p></div>';
?>
<?php
}
?>

<h2><?php _e("WP PT-Viewer", WP_PTVIEWER_I18N_DOMAIN); ?> <?php echo $wpptv_plugin->options['active_version']; ?> - <?php _e("Importer", WP_PTVIEWER_I18N_DOMAIN); ?></h2>

<ul class="subsubsub">
	<li><a href="options-general.php?page=wp-ptviewer" ><?php _e("Options", WP_PTVIEWER_I18N_DOMAIN); ?></a> | </li>
	<li><a href="options-general.php?page=wp-ptviewer&view=help" ><?php _e("Help", WP_PTVIEWER_I18N_DOMAIN); ?></a> | </li>
	<li><a href="options-general.php?page=wp-ptviewer&view=demo" ><?php _e("Demo", WP_PTVIEWER_I18N_DOMAIN); ?></a> | </li>
	<li><?php _e("Importer", WP_PTVIEWER_I18N_DOMAIN); ?> | </li>
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

<form name="Import" action="options-general.php?page=wp-ptviewer&view=importer" method="post">
	<input type="hidden" name="wpptv_import_submit" value="wpptv_import_submit" />
	
	<p class="submit">
		<input type="submit" name="Submit" value="<?php _e('Convert old ptviewer tags', WP_PTVIEWER_I18N_DOMAIN); ?> &raquo;" />
	</p>
</form>
</div>