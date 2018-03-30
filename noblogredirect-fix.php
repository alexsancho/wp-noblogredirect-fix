<?php
/**
 * Plugin Name: WP NOBLOGREDIRECT fix
 * Plugin URI: https://github.com/alexsancho/wp-noblogredirect-fix
 * Description: Fixes bad behaviour with 404 redirect when NOBLOGREDIRECT constant is defined on Multisite installs.
 * Author: Alex Sancho
 * Version: 1.0.0
 * Requires WP: 4.9.4
 */

remove_action( 'template_redirect', 'maybe_redirect_404' );
