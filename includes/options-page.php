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

<script type="text/javascript">
function setDefaultjar_url() {
	document.getElementById('jar_url').value = '<?php echo get_option('siteurl') . '/wp-content/plugins/wp-ptviewer/applets/ptviewer.jar'; ?>';
	return false;
}
</script>

<div class="wrap">

<?php 	
global $wpptv_plugin;	
if (isset($_POST['wpptv_options_submit'])) {
	$wpptv_plugin->options['jar_url'] = $_POST['jar_url'];
	$wpptv_plugin->options['default_applet_width'] = $_POST['default_applet_width'];
	$wpptv_plugin->options['default_applet_height'] = $_POST['default_applet_height'];
	$wpptv_plugin->options['default_image_path'] = $_POST['default_image_path'];
	$wpptv_plugin->options['default_div_class'] = $_POST['default_div_class'];
	$wpptv_plugin->save_options();
?>
<div id="message" class="updated fade">
	<p><?php _e('Options set successfully.', WP_PTVIEWER_I18N_DOMAIN); ?></p>
</div>
<?php
}
?>

<h2><?php _e("WP PT-Viewer", WP_PTVIEWER_I18N_DOMAIN); ?> <?php echo $wpptv_plugin->options['active_version']; ?> - <?php _e("Options", WP_PTVIEWER_I18N_DOMAIN); ?></h2>

<ul class="subsubsub">
	<li><?php _e("Options", WP_PTVIEWER_I18N_DOMAIN); ?> | </li>
	<li><a href="options-general.php?page=wp-ptviewer&view=help" ><?php _e("Help", WP_PTVIEWER_I18N_DOMAIN); ?></a> | </li>
	<li><a href="options-general.php?page=wp-ptviewer&view=demo" ><?php _e("Demo", WP_PTVIEWER_I18N_DOMAIN); ?></a> | </li>
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

<form name="SetOptions" action="options-general.php?page=wp-ptviewer" method="post">
	<input type="hidden" name="wpptv_options_submit" value="wpptv_options_submit" />
	
	<table class="form-table" width="100%" cellspacing="2" cellpadding="5">
	<tr title="<?php _e("location of the ptviewer.jar file (absolute path in your web server, should start with /).", WP_PTVIEWER_I18N_DOMAIN); ?>">
		<th scope="row" valign="top">
			<label>
				<?php _e("PtViewer jar path", WP_PTVIEWER_I18N_DOMAIN); ?> 
				(<a href="#" onclick="setDefaultjar_url();"><?php _e("Reset", WP_PTVIEWER_I18N_DOMAIN); ?></a>)
			</label>
		</th>
		<td>
			<input type="text" id ="jar_url" name="jar_url" value="<?php echo $wpptv_plugin->options['jar_url'];?>" style="width: 600px;" />
		</td>
	</tr>
	
	<tr title="<?php _e("default path where you can find the panorama images (relative to your blog url, should start with /).", WP_PTVIEWER_I18N_DOMAIN); ?>">
		<th scope="row" valign="top">
			<label>
				<?php _e("Default image path", WP_PTVIEWER_I18N_DOMAIN); ?>
			</label>
		</th>
		<td>
			<input type="text" name="default_image_path" value="<?php echo $wpptv_plugin->options['default_image_path'];?>" style="width: 600px;" />
		</td>
	</tr>
	
	<tr title="<?php _e("default width of the applet.", WP_PTVIEWER_I18N_DOMAIN); ?>">
		<th scope="row" valign="top">
			<label>
				<?php _e("Default applet width", WP_PTVIEWER_I18N_DOMAIN); ?>
			</label>
		</th>
		<td>
			<input type="text" name="default_applet_width" value="<?php echo $wpptv_plugin->options['default_applet_width'];?>" />
		</td>
	</tr>
	
	<tr title="<?php _e("default height of the applet.", WP_PTVIEWER_I18N_DOMAIN); ?>">
		<th scope="row" valign="top">
			<label>
				<?php _e("Default applet height", WP_PTVIEWER_I18N_DOMAIN); ?>
			</label>
		</th>
		<td>
			<input type="text" name="default_applet_height" value="<?php echo $wpptv_plugin->options['default_applet_height'];?>" />
		</td>
	</tr>
	
	<tr title="<?php _e("default CSS class to apply to the div element around the applet.", WP_PTVIEWER_I18N_DOMAIN); ?>">
		<th scope="row" valign="top">
			<label>
				<?php _e("CSS class", WP_PTVIEWER_I18N_DOMAIN); ?>
			</label>
		</th>
		<td>
			<input type="text" name="default_div_class" value="<?php echo $wpptv_plugin->options['default_div_class'];?>" />
		</td>
	</tr>
	</table>

	<p class="submit">
		<input type="submit" name="Submit" value="<?php _e('Set options', WP_PTVIEWER_I18N_DOMAIN); ?> &raquo;" />
	</p>
</form>
</div>