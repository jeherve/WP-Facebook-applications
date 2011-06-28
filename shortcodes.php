<?php
/**
 * Share button shortcode
 * Shortoode: fbshare
 */
function werewp_fbshare_shortcode() {
	return '<a href="#" onclick="streamPublish(); return false;">Demo</a>';
}
add_shortcode( 'fbshare', 'werewp_fbshare_shortcode' );
?>