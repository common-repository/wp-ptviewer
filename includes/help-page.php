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
<h2><?php _e("WP PT-Viewer", WP_PTVIEWER_I18N_DOMAIN); ?> <?php echo $wpptv_plugin->options['active_version']; ?> - <?php _e("Help", WP_PTVIEWER_I18N_DOMAIN); ?></h2>

<ul class="subsubsub">
	<li><a href="options-general.php?page=wp-ptviewer" ><?php _e("Options", WP_PTVIEWER_I18N_DOMAIN); ?></a> | </li>
	<li><?php _e("Help", WP_PTVIEWER_I18N_DOMAIN); ?> | </li>
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

<p><?php _e('The style of the panorama can be changed using the CSS file included in the plugin\'s "/wp-ptviewer/css/" subfolder.', WP_PTVIEWER_I18N_DOMAIN); ?></p>

<p><?php _e('To insert a panorama in your post or page, use the following syntax:', WP_PTVIEWER_I18N_DOMAIN); ?> 
<ul>
	<li>
		<code>
			[ptviewer <i><?php _e('parameters', WP_PTVIEWER_I18N_DOMAIN); ?></i>]
				<?php _e('The title of your panorama', WP_PTVIEWER_I18N_DOMAIN); ?>
			[/ptviewer]
		</code>
	</li>
	<li>
		<code>
			[ptviewer <i><?php _e('parameters', WP_PTVIEWER_I18N_DOMAIN); ?></i> /]
		</code>
	</li>
</ul>
</p>

<p><?php _e('The parameters you must specify are:', WP_PTVIEWER_I18N_DOMAIN); ?> 
<ul>
	<li>
		<strong>imagewidth <i><?php _e("(required):", WP_PTVIEWER_I18N_DOMAIN); ?></i></strong> 
		<?php _e("the width of the image file you want to visualise.", WP_PTVIEWER_I18N_DOMAIN); ?>
	</li>
	<li>
		<strong>imageheight <i><?php _e("(required):", WP_PTVIEWER_I18N_DOMAIN); ?></i></strong> 
		<?php _e("the height of the image file you want to visualise.", WP_PTVIEWER_I18N_DOMAIN); ?>
	</li>
	<li>
		<strong>horizon <i><?php _e("(required):", WP_PTVIEWER_I18N_DOMAIN); ?></i></strong> 
		<?php _e('the horizon position in the image relative to the top of the image. You can find this out using your favorite image edition software.', WP_PTVIEWER_I18N_DOMAIN); ?>
	</li>
	<li>
		<strong>hfov <i><?php _e("(required):", WP_PTVIEWER_I18N_DOMAIN); ?></i></strong> 
		<?php _e('the horizontal field of view in degrees covered by the image. You should write it down when you assemble your images using your panorama stiching software. For instance, a full panorama will have an horizontal field of view of 360 degrees.', WP_PTVIEWER_I18N_DOMAIN); ?>
	</li>
</ul>
</p>

<p><?php _e('The parameters you can additionally specify are:', WP_PTVIEWER_I18N_DOMAIN); ?> 
<ul>
	<li>
		<strong>image</strong> <i><?php _e("(optional):", WP_PTVIEWER_I18N_DOMAIN); ?></i>
		<?php _e('the image you want to visualise. This is the path relative to the default image path you specify in the previous options.', WP_PTVIEWER_I18N_DOMAIN); ?>
	</li>
	<li>
		<strong>href</strong> <i><?php _e("(optional):", WP_PTVIEWER_I18N_DOMAIN); ?></i>
		<?php echo( __('the image you want to visualise. This is the full URL of the image. <strong>If the <i>', WP_PTVIEWER_I18N_DOMAIN) 
				. WP_PTVIEWER_IMAGE_TAG_PARAM 
				. __( '</i> parameter is specified, this parameter will be ignored.</strong>', WP_PTVIEWER_I18N_DOMAIN)); ?>
	</li>
	<li>
		<strong>width</strong> <i><?php _e("(optional):", WP_PTVIEWER_I18N_DOMAIN); ?></i>
		<?php _e('the width of the applet as it will appear in your post.', WP_PTVIEWER_I18N_DOMAIN); ?> 
		<?php _e('If not specified, it uses the value specified in the options above.', WP_PTVIEWER_I18N_DOMAIN); ?>
	</li>
	<li>
		<strong>height</strong> <i><?php _e("(optional):", WP_PTVIEWER_I18N_DOMAIN); ?></i>
		<?php _e('the height of the applet as it will appear in your post.', WP_PTVIEWER_I18N_DOMAIN); ?> 
		<?php _e('If not specified, it uses the value specified in the options above.', WP_PTVIEWER_I18N_DOMAIN); ?>
	</li>
	<li>
		<strong>cssclass</strong> <i><?php _e("(optional):", WP_PTVIEWER_I18N_DOMAIN); ?></i>
		<?php _e('the CSS class to apply to the div container around the applet.', WP_PTVIEWER_I18N_DOMAIN); ?> 
		<?php _e('If not specified, it uses the value specified in the options above.', WP_PTVIEWER_I18N_DOMAIN); ?>
	</li>
	<li>
		<strong>debug</strong> <i><?php _e("(optional):", WP_PTVIEWER_I18N_DOMAIN); ?></i>
		<?php _e('if set to a value other than 0, some additional debug information will be outputed below the panorama.', WP_PTVIEWER_I18N_DOMAIN); ?> 
	</li>
</ul>
</p>

</div>
	