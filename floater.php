<?php
/*
Plugin Name: Floater
Plugin URI: https://bitbucket.com/cftp/floater
Description: A floating sidebar area triggered by scroll.
Author: Scott Evans (Code For The People)
Version: 1.0
Author URI: http://codeforthepeople.com
Text Domain: floater
Domain Path: /assets/languages/
License: GPL2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Copyright © 2013 Code for the People ltd

                _____________
               /      ____   \
         _____/       \   \   \
        /\    \        \___\   \
       /  \    \                \
      /   /    /          _______\
     /   /    /          \       /
    /   /    /            \     /
    \   \    \ _____    ___\   /
     \   \    /\    \  /       \
      \   \  /  \____\/    _____\
       \   \/        /    /    / \
        \           /____/    /___\
         \                        /
          \______________________/


This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/


class floater {

	/**
	* floater class
	*/
	public function __construct() {

		// actions
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		add_action( 'widgets_init', array( $this, 'floater_sidebar' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'floater_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'floater_scripts' ) );
		add_action( 'wp_footer', array( $this, 'floater_footer') );

	}

	/**
	 * load_textdomain
	 *
	 * @author  Scott Evnas
	 * @return void
	 */
	function load_textdomain() {
		load_plugin_textdomain( 'floater', false, dirname( plugin_basename( __FILE__ ) ) . '/assets/languages/' );
	}

	/**
	 * floater_sidebar
	 *
	 * Register sidebar for floating widget
	 *
	 * @author Scott Evans
	 * @return void
	 */
	function floater_sidebar() {

		register_sidebar(
			array (
				'id'                 => 'floater',
				'name'               => __('Floating Sidebar', 'floater'),
				'description'        => __('Add widgets to show in your floating sidebar.', 'floater'),
				'before_widget'      => '<section id="%1$s" class="%2$s floater-sidebar-widget">',
				'after_widget'       => '</section>',
				'before_title'       => '<h4 class="floater-title">',
				'after_title'        => '</h4>'
			)
		);
	}

	/**
	 * floater_styles
	 *
	 * Output CSS files
	 *
	 * @author Scott Evans
	 * @return void
	 */
	function floater_styles() {

		if (! is_active_sidebar( 'floater' ) )
			return false;

		// register all css
		wp_register_style( 'floater', plugins_url( 'assets/css/floater.css', __FILE__ ), array(), filemtime( plugin_dir_path( __FILE__ ) . 'assets/css/floater.css' ) );

		// enqueue
		wp_enqueue_style( 'floater' );
	}

	/**
	 * floater_scripts
	 *
	 * Output JS files
	 *
	 * @author Scott Evans
	 * @return void
	 */
	function floater_scripts() {

		if (! is_active_sidebar( 'floater' ) )
			return false;

		// register all scripts
		wp_register_script( 'jquery-cookie', plugins_url( 'assets/js/jquery.cookie.js', __FILE__ ), array(), filemtime( plugin_dir_path( __FILE__ ) . 'assets/js/jquery.cookie.js' ), true);
		wp_register_script( 'floater', plugins_url( 'assets/js/floater.js', __FILE__ ), array('jquery-cookie'), filemtime( plugin_dir_path( __FILE__ ). 'assets/js/floater.js' ), true );

		// enqueue
		wp_enqueue_script('floater');
	}

	/**
	 * floater_footer
	 *
	 * Output the sidebar in the footer
	 *
	 * @author Scott Evans
	 * @return void
	 */
	function floater_footer() {

		if (! is_active_sidebar( 'floater' ) )
			return false;

		?>
		<aside id="floater-sidebar">
			<a href="#" class="floater-close"><span class="icon-close">x</span></a>
			<?php dynamic_sidebar( 'floater' ); ?>
		</aside>
		<?php
	}
}

global $floater;
$floater = new floater();